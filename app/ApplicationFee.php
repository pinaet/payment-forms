<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ticket;

class ApplicationFee extends Model
{
    protected   $guarded   = [];

    public function getDefaultAttributes()
    {
        /**
         * 
            $table->bigIncrements('id');
            $table->bigInteger('endpoint_id')->nullable();  //get this id from the 'gate' project
            $table->string('student_name')->nullable();     //contact_name
            $table->string('parent_name')->nullable();      //phone
            $table->string('parent_email')->nullable();     //email
            $table->string('payment_type')->nullable();     //
            $table->string('applicant_id')->nullable();     //reference_order
            $table->string('ref')->nullable();              //student_id.ref
            $table->decimal('fee_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->string('currency', 3)->default('THB');
            $table->string('source_type')->nullable();      //card, unionpay, wechat, alipay
            $table->tinyInteger('paid')->default(0);        //0=unpaid, 1=paid
            $table->timestamps();
         */
        
        $ticket                         = Ticket::where('endpoint_id','3')->first();

        $attributes['endpoint_id']      = $ticket->endpoint_id;        //get this id from the 'gate' project
        $attributes['student_name']     = '';       //contact_name
        $attributes['parent_name']      = '';       //phone
        $attributes['parent_email']     = '';       //email
        $attributes['payment_type']     = 'Application Fee';       //
        $attributes['applicant_id']     = '';       //reference_order
        $attributes['ref']              = 'ref2_id'; 
        $attributes['fee_amount']       = 0;        //amount
        $attributes['total_amount']     = $ticket->endpoint_value;        //amount
        $attributes['currency']         = 'THB';     
        $attributes['source_type']      = '';         
        $attributes['paid']             = 0;

        return $attributes;
    }
}
