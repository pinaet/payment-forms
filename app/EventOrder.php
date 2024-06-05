<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventOrder extends Model
{
    protected   $guarded   = [];

    public function getDefaultAttributes( $request )
    {
        /**
         * 
            $table->bigIncrements('id');
            $table->bigInteger('event_id')->nullable();
            $table->bigInteger('event_ticket_id')->nullable();
            $table->bigInteger('gate_endpoint_id')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('reference_order')->nullable();
            $table->string('ref1')->nullable();
            $table->string('ref2')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 3)->default('THB');
            $table->string('source_type')->nullable();
            $table->tinyInteger('paid')->default(0);//0=unpaid, 1=paid
            $table->tinyInteger('consent_1')->default(0);//0=no, 1=yes
            $table->tinyInteger('consent_2')->default(0);//0=no, 1=yes
            $table->timestamps();
         */
        // $attributes['id']              = 0;        
        $attributes['event_id']        = isset( $request['event_id'] )        ? $request['event_id']         : '';         
        $attributes['event_ticket_id'] = isset( $request['event_ticket_id'] ) ? $request['event_ticket_id']  : 0;  
        $attributes['gate_endpoint_id']= isset( $request['gate_endpoint_id'] )? $request['gate_endpoint_id'] : 0;  
        $attributes['contact_name']    = isset( $request['contact_name'] )    ? $request['contact_name']     : '';         
        $attributes['phone']           = isset( $request['phone'] )           ? $request['phone']            : '';     
        $attributes['email']           = isset( $request['email'] )           ? $request['email']            : '';     
        $attributes['reference_order'] = isset( $request['reference_order'] ) ? $request['reference_order']  : '';             
        $attributes['ref1']            = isset( $request['ref1'] )            ? $request['ref1']             : ''; 
        $attributes['ref2']            = isset( $request['ref2'] )            ? $request['ref2']             : 1;         
        $attributes['amount']          = isset( $request['amount'] )          ? $request['amount']           : 0;     
        $attributes['currency']        = isset( $request['currency'] )        ? $request['currency']         : 'THB';     
        $attributes['source_type']     = isset( $request['source_type'] )     ? $request['source_type']      : '';         
        $attributes['paid']            = isset( $request['paid'] )            ? $request['paid']             : 0;         
        $attributes['consent_1']       = isset( $request['consent_1'] )       ? $request['consent_1']        : 0;         
        $attributes['consent_2']       = isset( $request['consent_2'] )       ? $request['consent_2']        : 0; 
        $attributes['consent_3']       = isset( $request['consent_3'] )       ? $request['consent_3']        : 0;         
        $attributes['consent_4']       = isset( $request['consent_4'] )       ? $request['consent_4']        : 0; 

        return $attributes;
    }
}
