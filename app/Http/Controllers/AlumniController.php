<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use GuzzleHttp\Client;

use App\Http\Controllers\MailsController;

use App\Alumnus;
use App\School;
use App\Country;
use App\AlumniEventStatus;

class AlumniController extends Controller
{
    public function index()
    {
        $start_year= config('ticket.start_year');

        $alumnus   = (new Alumnus)->getDefaultAttributes();
        $schools   = School::all();
        $countries = Country::orderBy('iso')->get();

        return view( 'pages.alumni.index', [
            'start_year'=> $start_year,
            'alumnus'   => $alumnus,
            'schools'   => $schools,
            'countries' => $countries,
        ] );
    }

    public function store()
    {
        $attributes = json_decode(request()->alumnus, true);
        // dd($alumnus, request()->all() );

        // request()->validate([
        //     'firstname' => 'required',
        //     'lastname' => 'required',
        //     'school_id' => 'required',
        //     'graduated_year' => 'required',
        //     'country_id' => 'required',
        //     'phone' => 'required',
        //     'email' => 'email',
        //     'ioh_connect' => 'required',
        //     'terms_agreed' => 'accepted',
        // ]);
        // dd($attributes );

        //update data into table
        $alumnus = Alumnus::where( 'email', $attributes['email'] )->first();

        if( empty($alumnus)==false ){

            $alumnus['firstname']      = $attributes['firstname'];
            $alumnus['lastname']       = $attributes['lastname'];
            $alumnus['school_id']      = $attributes['school_id'];
            $alumnus['graduated_year'] = $attributes['graduated_year'];
            $alumnus['country_id']     = $attributes['country_id'];
            $alumnus['phone']          = $attributes['phone'];
            $alumnus['email']          = $attributes['email'];
            $alumnus['ioh_connect']    = $attributes['ioh_connect'];
            $alumnus['terms_agreed']   = $attributes['terms_agreed'];

            $alumnus->save();
        }
        else{
            $alumnus = Alumnus::create($attributes);
        }

        //sending email(s)
        // dd( $alumnus)
        $http    = new Client;
        $data    = json_encode( $alumnus );

        try {
            $http->post( url('/alumni/email'), [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => ['alumnus' => $data],
            ]);
            // dd($response->getBody());
        } catch (\Exception $e) {
            dd( $e );
        }


        return view( 'pages.alumni.result', [
            'alumnus' => $alumnus
        ]);
    }

    public function email()
    {
        $alumnus = json_decode( request()->alumnus, true );

        // dd( $alumnus );

        (new MailsController)->sendEventMail($alumnus);

        if ($alumnus['ioh_connect'] == 1) {
            (new MailsController)->sendMembershipMail($alumnus);
        }
    }

    public function report()
    {
        //gen data against db
        $sql             = "
        SELECT
            a.id,
            a.firstname ,
            a.lastname ,
            s.school ,
            a.graduated_year ,
            c.phonecode ,
            a.phone ,
            a.email ,
            a.ioh_connect ,
            a.terms_agreed ,
            a.event_status_id ,
            a.created_at,
            a.updated_at
        FROM alumni a
        left join countries c on a.country_id = c.id
        left join schools s on a.school_id = s.id
        where email != 'naet_ph@harrowschool.ac.th'
        ";

        $alumni       = DB::select( $sql );
        $alumni       = json_decode(json_encode($alumni), true);

        // $alumni       = Alumnus::where( 'email', '!=', 'naet_ph@harrowschool.ac.th' )->get();

        $eventStatuses= AlumniEventStatus::all();

        return view( 'pages.alumni.report', [
            'alumni'        => $alumni,
            'eventStatuses' => $eventStatuses,
        ] );
    }

    public function report_update()
    {
        $alumnus_temp = json_decode(request()->alumnus,true);

        $alumnus = Alumnus::find( $alumnus_temp['id'] );
        $alumnus['event_status_id'] = $alumnus_temp['event_status_id'];
        $alumnus->save();

        return response( '200 OK' );
    }

    public function getArrayTableNew( $data, $opt=null )
    {
        $html  = '';

        if( !$data )
        {
            $html  = '<tr><td>No Data</td></tr>';
            return $html;
        }

        // $html .= '<table id="filter" class="table table-striped"><thead>';
        // foreach( $data as $dat)
        // {
        //     foreach( $dat as $key => $value )
        //     {
        //         $html .= "<th>".(string)$key."</th>";
        //     }
        //     break;
        // }
        // $html .= "</thead></table>";

        $html .= '<table id="mytable" class="table table-striped table-bordered table-hover" width="100%"><thead><tr>';
        foreach( $data as $dat)
        {
            foreach( $dat as $key => $value )
            {
                $html .= "<th>".(string)$key."</th>";
            }
            break;
        }
        $html .= "</tr></thead>";

        foreach( $data as $dat )
        {
            $html .= "<tr>";
            foreach( $dat as $key => $value )
            {
                $html .= "<td>".(string)$value."</td>";

            }
            $html .= "</tr>";
        }

        if( $opt=="tfoot")
        {
            $html .= "<tfoot><tr>";
            foreach( $data as $dat)
            {
                foreach( $dat as $key => $value )
                {
                    $html .= "<th>".(string)$key."</th>";
                }
                break;
            }
            $html .= "</tr></tfoot>";
        }
        $html .= "</table>";
        dd( $html);

        return $html;
    }
}
