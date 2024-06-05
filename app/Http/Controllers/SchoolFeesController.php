<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\SchoolFee;

class SchoolFeesController extends Controller
{
    public function index()
    {
        if( env( 'APP_UNDER_MAINTENANCE', false ) ){
            return view('pages.under-maintenance');
        }
        $school_fee = (new SchoolFee)->getDefaultAttributes();

        return view( 'pages.school-fee.index', [
            'school_fee' => $school_fee
        ]);
    }

    public function checkParent()
    {
        // get the post values
        
        $customer_name		= request()->customer_name;//str_replace("'","''",$_POST['customer_name']);
        $customer_phone		= request()->customer_phone;//str_replace("'","''",$_POST['customer_phone']);
        $customer_email		= request()->customer_email;//str_replace("'","''",$_POST['customer_email']);
    
        // insert data to table: FrontPageLog
        // include("../config/engagedb.php");
    
        // validate variables
        // product name
        $sql = "SELECT DISTINCT 
                    (COALESCE( (CASE WHEN LTRIM(ld.Description)='' THEN NULL ELSE ld.Description END),'')) AS 'Prefix',
                    RTRIM(LTRIM(cm.FirstName)) FirstName, 
                    LTRIM(RTRIM(cm.LastName)) LastName, 
                    cm.ContactName,
                    cei.EmailID, 
                    cti.TelephoneNumber
                FROM PupilContacts pc
                INNER JOIN ContactMaster cm ON pc.ContactId = cm.ContactID
                INNER JOIN ContactEmailInformation cei ON cm.ContactID = cei.ContactID
                LEFT  JOIN ContactTelephoneInformation cti ON cm.ContactID = cti.ContactID AND cti.TelephoneType='Main'
                LEFT  JOIN LookupDetails ld ON ld.LookupDetailsID = cm.Prefix AND ld.LookupID='3012'
                WHERE cei.EmailID='$customer_email'
        ";
        $parents = DB::connection('engage')->select( $sql );
        
        // $col_name       = array( 'Prefix', 'FirstName', 'LastName', 'ContactName', 'EmailID', 'TelephoneNumber' );
    
        $Prefix         = '';
        $FirstName	    = '';
        $LastName	    = '';
        $customer_name  = '';
        $customer_phone = '';
        $customer_email = '';
        $found_email    = false;
        $found_contact  = true;
    
        //1.count row
        $cnt_row     = count($parents);
        if( $cnt_row>0 )
        {        
            $found_email  = true; //found email
            $found_contact= false;//reset and re-check after email found
    
            //2. prepare array set
            $cnt_match    = array();
            $current_row  = 0; //current row
            $contact_name = preg_split( "/[\ \n\,]+/", trim( request()->customer_name ) );
            $cnt_value    = count( $contact_name );
            while( $current_row<count($parents) )
            {            
                $row          = $parents[ $current_row ];
                $ContactName  = preg_split( "/[\ \n\,]+/", $row->ContactName );
                $cnt_split    = count( $ContactName );
                if( $cnt_value==$cnt_split )
                {
                    $cnt_match[ $current_row ] = 0;
                    for( $i=0; $i<$cnt_split; $i++ )
                    {
                        $str_1 = strtolower( trim( $contact_name[ $i ] ) ); //for in-casensitive strtolower()
                        $str_2 = strtolower( trim( $ContactName[  $i ] ) );
                        if( $str_1==$str_2 )
                        {
                            $cnt_match[ $current_row ]++;
                        }
                    }
                    if( $cnt_match[ $current_row ]==$cnt_split )
                    {
                        $chosen_row    = $current_row;
                        $found_contact = true;
                        break;
                    }
                }
                $current_row++;
            }
    
            //soft check mode
            if( $found_contact==false )
            {
                //2. prepare array set
                $current_row  = 0; //current row
                while( $current_row<$cnt_row )
                {
                    $row          = $parents[ $current_row ];
                    // dd( $cnt_value, $cnt_split );
                    $ContactName  = preg_split( "/[\ \n\,]+/", $row->ContactName );
                    $cnt_split    = count( $ContactName );
                    $cnt_match[ $current_row ] = 0;
                    for( $i=0; $i<$cnt_value; $i++ )
                    {
                        $str_1 = strtolower( trim( $contact_name[ $i ] ) ); //for in-casensitive strtolower()
                        for( $j=0; $j<$cnt_split; $j++ )
                        {
                            //count matches
                            $str_2 = strtolower( trim( $ContactName[ $j ] ) );
                            if( $str_1 == $str_2 )
                            {
                                $cnt_match[ $current_row ] ++;
                                break;
                            }
                        }
                    }
                    $current_row ++;
                }
    
                $chosen_row  = 0; //select the most correct row
                //find the record with most matches
                for( $i=1; $i<$cnt_row; $i++ )
                {
                    if( $cnt_match[ $chosen_row ] < $cnt_match[ $i ] )
                    {
                        $chosen_row = $i;
                    }
                }
    
                if( $cnt_match[ $chosen_row ]>1 )
                    $found_contact = true;
            }
            
    
            //index to fetch the record in stmt.. may not work and use a string to index
            if( $found_contact )
            {
                $row            = $parents[ $chosen_row ];
    
                $Prefix         = $row->Prefix;
                $FirstName	    = $row->FirstName;
                $LastName	    = $row->LastName;
                $customer_name	= $row->ContactName;
                $customer_phone	= $row->TelephoneNumber;
                $customer_email	= $row->EmailID;
            }
        }
    
        $data = array(
             "Prefix"         => $Prefix        
            ,"FirstName"	  => $FirstName	   
            ,"LastName"	      => $LastName	   
            ,"customer_name"  => $customer_name
            ,"customer_phone" => $customer_phone
            ,"customer_email" => $customer_email
            ,"found_email"    => $found_email
            ,"found_contact"  => $found_contact
        );    
    
        return $data;
    }

    public function store()
    {
        $school_fee = json_decode( request()->schoolFee, 1 );

        $data       = SchoolFee::create( $school_fee );
        // dd( $school_fee );
        return $data;
    }

    public function orderNotify()
    {
        $data = request()->data;

        $reference_order    = $data['reference_order'];
        $source_type        = $data['source_type'];
        $status             = $data['status'];
        $id                 = $data['ref2'];//id
        $student_code       = $data['ref3'];//student_code

        $school_fee = SchoolFee::where(  'id'             , $id              )
                                ->where( 'reference_order', $reference_order )
                                ->where( 'student_code'   , $student_code    )
                                ->first();

        $school_fee['source_type'] = $source_type;
        $school_fee['paid']        = $status=='c' ? 1 : 0;

        $school_fee->save();

        return response( '200 OK' );
    }
}
