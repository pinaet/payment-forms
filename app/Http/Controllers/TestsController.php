<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\ApplicationFeeController;

class TestsController extends Controller
{
    public function index()
    {
        $data = (new ApplicationFeeController)->getOpenApplyAllData();
        // get the post values
        $students           = null;
        $parents            = null;
        
        $student_name   = 'thelma lemaitre';//str_replace("'","''",$_POST['customer_name']);
        $students       = $data['students'];
        $parents        = $data['linked']['parents'];
        $parent_email   = 'anneleen_er@harrowschool.ac.th';

        $student            = null;
        $parent             = null;
        $automatic_mode     = true;        
        if($automatic_mode){
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

        $invoice_number = (new ApplicationFeeController)->getInvoiceNumber($student['id']);
    
        $data = array(
             "student"          => $student        
            ,"parent"           => $parent	   
            ,"invoice_number"   => $invoice_number	   
        );    

        dd($data);
    }
}
