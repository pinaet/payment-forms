<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolFee extends Model
{
    protected   $guarded   = [];

    public function getDefaultAttributes()
    {
        /**
         * 
            $table->bigIncrements('id');
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('reference_order')->nullable();
            $table->string('ref')->nullable();
            $table->string('student_code')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 3)->default('THB');
            $table->string('source_type')->nullable();
            $table->tinyInteger('paid')->default(0);//0=unpaid, 1=paid
            $table->timestamps();
         */
        $attributes['contact_name']    = '';         
        $attributes['phone']           = '';     
        $attributes['email']           = '';     
        $attributes['reference_order'] = '';             
        $attributes['ref']             = 'ref2.id'; 
        $attributes['student_code']    = '';         
        $attributes['amount']          = 0;     
        $attributes['currency']        = 'THB';     
        $attributes['source_type']     = '';         
        $attributes['paid']            = 0; 

        return $attributes;
    }
}
