<?php

namespace App\Http\Controllers;

use DB;
use GuzzleHttp\Client;
use App\ApplicationFee;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class ApplicationFeeController extends Controller
{
    private function format_date($source_date)
    {
        return date('Y-m-d', strtotime($source_date));
    }

    public function index($student_name=null)
    {
        $data           = $this->getOpenApplyAllData();
        $application_fee= (new ApplicationFee)->getDefaultAttributes();

        if(isset($student_name)){
            //find the student and their parent  
            $names          = explode( '--', $student_name );//Pupil3Name--Pupil3Surname
            $student_name   = $names[0] . ' ' . $names[1];

            $birth_date     = isset($names[2]) ? $names[2] : '';

            $temp_data      = $this->checkStudent( $student_name, $data, $birth_date ); //isset($data) ? (object)$data : null 
            $student        = $temp_data['student'];
            $parent         = $temp_data['parent'];
            
            $application_fee['student_name']  = $student['first_name'] . ' ' . $student['last_name'];
            $application_fee['parent_name']   = $parent['name'];
            $application_fee['parent_email']  = $parent['email'];
            $application_fee['applicant_id']  = $temp_data['invoice_number'];
        }      
        

        return view( 'pages.application-fee.index', [
            'application_fee'   => $application_fee,
            'data'              => $data,
        ]);
    }

    public function getOpenApplyAllData()
    {
        /**
         * fetch data from OA API
         */
        $http = new Client;
        $openapply_api_url  = config('ticket.application-fee.bangkok.openapply_api_url');
        $opa_auth_token     = config('ticket.application-fee.bangkok.opa_auth_token');
        $since_date         = date('Y-m-d', strtotime( ' -90 days') );
        $base_url           = $openapply_api_url.'/?auth_token='.$opa_auth_token.'&since_date='.$since_date;
        try
        {
            $response = $http->get( $base_url, [
                'headers' => [
                    'Content-Type'=>'Application/x-www-form-urlendcoded',
                ],
            ]);
        }
        catch( \Exception $e )
        {
            return dd('OpenApply getOpenApplyAllData :',$e->getMessage());
        }
        $data    = json_decode((string) $response->getBody(), true);
        
        $students           = $data['students'];
        $status             = 'pending';
        $students           = Arr::where($students, function ($value, $key) use($status) {
            return $value['status'] != $status;
        });
        $data['students']   = $students;

        return $data;
    }

    public function checkStudent( $student_name=null, $data=null, $birth_date=null )
    {
        // get the post values
        $student            = null;
        $parent             = null;
        $invoice_number     = null;

        $students           = null;
        $parents            = null;
        $automatic_mode     = false;
        if( $student_name==null && $data==null && empty($birth_date) ){//manual search
            $student_name   = request()->student_name;
            $student_name   = preg_replace('/\s\s+/', ' ', $student_name); //replace all whitespace with a single space
            $students       = request()->data['students'];
            $parents        = request()->data['linked']['parents'];
            $parent_email   = request()->parent_email;
            $automatic_mode = false;
        } else {//automactic search
            $students       = $data['students'];
            $parents        = $data['linked']['parents'];
            $automatic_mode = true;
        }
 
        if($automatic_mode){
            //find student
            foreach( $students as $std ){
                if( empty($birth_date)==false && empty($student_name)==false ){
                    if( strtolower($std['first_name'] . ' ' . $std['last_name']) == strtolower($student_name) &&
                        $this->format_date($std['birth_date']) == $this->format_date($birth_date)             ){
                        $student = $std;
                        break;
                    }
                }
                else {
                    if( strtolower($std['first_name'] . ' ' . $std['last_name']) == strtolower($student_name) ){
                        $student = $std;
                        break;
                    }
                }
            }

            //find parent of the student
            if( isset($student) ){
                $parent_ids     = $student['parent_ids'];
                $parent_id      = '';
                for( $p=0; $p<count($parent_ids); $p++ ){
                    $parent_id = $parent_ids[$p];
                    for( $i=0; $i<count($parents); $i++ ){
                        if( $parents[$i]['id']==$parent_id ){ 
                            $parent = $parents[$i];
                            break;
                            //if( isset($parents[$i]['custom_fields']['invoice_sent_y_n']) && strtolower($parents[$i]['custom_fields']['invoice_sent_y_n'])=='yes'){ }
                        }
                    }
                    if( isset($parent) ) break;
                }
            }
        }
        else{
            $filtered_parents = Arr::where($parents, function ($value, $key) use($parent_email) {
                return $value['email'] == $parent_email;
            });

            //find student and their parent
            foreach( $filtered_parents as $p ) {
                foreach( $students as $std ){
                    if( strtolower($std['first_name'] . ' ' . $std['last_name']) == strtolower($student_name) ){
                        $parent_ids = $std['parent_ids'];
                        foreach( $parent_ids as $pid ){
                            if($p['id']==$pid){
                                $parent     = $p;
                                $student    = $std;
                                break;
                            }
                        }
                    }
                    if(isset($student)){
                        break;
                    }
                }
                if(isset($student)){
                    break;
                }
            }
        }

        if($student){
            $invoice_number = 'OA'.$this->getInvoiceNumber($student['id']);
        }
        
        sleep(1);
    
        $data = array(
            "student"          => $student        
           ,"parent"           => $parent	   
           ,"invoice_number"   => $invoice_number	     
        );    
    
        return $data;
    }

    public function getInvoiceNumber($id)
    {
        $http = new Client;
        $openapply_api_url  = config('ticket.application-fee.bangkok.openapply_api_url');
        $opa_auth_token     = config('ticket.application-fee.bangkok.opa_auth_token');
        $base_url           = $openapply_api_url.'/'.$id.'/payments?auth_token='.$opa_auth_token;
        try
        {
            $response = $http->get( $base_url, [
                'headers' => [
                    'Content-Type'=>'Application/x-www-form-urlendcoded',
                ],
            ]);
        }
        catch( \Exception $e )
        {
            return dd('OpenApply getOpenApplyAllData :',$e->getMessage());
        }
        $data               = json_decode((string) $response->getBody(), true);
        $invoice_number     = '';
        if(isset($data['payments'])){
            foreach ($data['payments'] as $payment) {
                $invoice_number = $payment['invoice_number'];
            }
        }
        return $invoice_number;        
    }

    public function store()
    {
        $application_fee = json_decode( request()->applicationFee, 1 );

        $data       = ApplicationFee::create( $application_fee );
        // dd( $application_fee );
        return $data;
    }

    public function orderNotify()
    {
        $data = request()->data;

        $invoice_number     = $data['reference_order'];
        $source_type        = $data['source_type'];
        $status             = $data['status'];
        $id                 = $data['ref2'];//id
        $ref3               = $data['ref3'];//invoice_number

        if( $invoice_number==$ref3 ){
            $invoice_number =$ref3;
        }

        $application_fee = ApplicationFee::where(  'id'   , $id              )
                                ->where( 'applicant_id'   , $invoice_number  )
                                ->first();

        $application_fee['source_type'] = $source_type;
        $application_fee['paid']        = $status=='c' ? 1 : 0;

        $application_fee->save();

        return response( '200 OK' );
    }
}
