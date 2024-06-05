<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use DB;

use App\Event;
use App\EventOrder;
use App\EventTicket;
use App\EventReport;
use App\EventUser;

class EventsController extends Controller
{
    public function index( $event_id=null, $ticket_id=null, Request $request )
    {
        // https://histest.harrowschool.ac.th/ticket/public/100014?dummy=1234
        // if( $event_id==null || $ticket_id==null ){
        //     dd( 'Invalid data to process ...' . $event_id . ' ' . $ticket_id );
        // }

        $event      = Event::find( $event_id );
        if(!isset($event))
            dd( 'Invalid event ...' );

        if($ticket_id==null){
            $tickets= EventTicket::where( 'event_id', $event_id )->get();
        }else{
            $tickets= EventTicket::where( 'id'      , $ticket_id)
                                    ->where( 'event_id', $event_id )->get();
        }

        $request['event_id']         = $event_id;
        $request['event_ticket_id']  = $ticket_id;
        $request['gate_endpoint_id'] = $event['gate_endpoint_id'];
        $request['currency']         = $tickets[0]['currency'];
        $eventOrder = (new EventOrder)->getDefaultAttributes( $request );
        // dd( $event['name'], $tickets[0]['name'], $request['currency'], $eventOrder );        

        return view( 'pages.event.index', [
            'event'     => $event,
            'tickets'   => $tickets,
            'eventOrder'=> $eventOrder,
        ]);
    }

    public function store()
    {
        $event_order = json_decode( request()->eventOrder, 1 );
        // dd( 'event_order', $event_order );

        $data        = EventOrder::create( $event_order );
        
        $data['reference_order'] = 'E'.$data['id'];
        $data->save();

        return $data;
    }

    public function orderNotify()
    {
        $data = request()->data;

        $reference_order    = $data['reference_order'];     //E10050028
        $id                 = substr($reference_order, 1);  // 10050028 -- removed 'E'
        $source_type        = $data['source_type'];
        $status             = $data['status'];
        /*
        $ref1               = $data['ref2'];//
        $ref2               = $data['ref3'];
        */

        $event_order = EventOrder::where( 'id'             , $id              )
                                 ->where( 'reference_order', $reference_order )
                                 ->first();

        $event_order['source_type'] = $source_type;
        $event_order['paid']        = $status=='c' ? 1 : 0;

        $event_order->save();

        return response( '200 OK' );
    }

    public function report( $event_id ){
        /**
         * event_reports(id, event_id, sql)
         * user(id, name, email, password)
         * event_user(id, user_id, event_id)
         */
        $event          = Event::find(        $event_id             );
        $event_report   = EventReport::where( 'event_id', $event_id )->get();
        $event_user     = EventUser::where(   'event_id', $event_id )->get();
        // dd($event->name);
        
        //gen data against db
        $sql            = $event_report[0]['sql'];
        $report         = DB::select( $sql );
        $report         = json_decode(json_encode($report), true);

        return view( 'pages.event.report', [
            'event'         => $event,
            'event_report'  => $event_report,
            'event_user'    => $event_user,
            'report'        => $report,
        ]);

    }
}
