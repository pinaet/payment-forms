<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumnus extends Model
{
    protected   $guarded   = [];

    public function getDefaultAttributes()
    {
        $attributes['firstname']        = '';
        $attributes['lastname']         = '';
        $attributes['school_id']        = 0;
        $attributes['graduated_year']   = 0;
        $attributes['country_id']       = 0;
        $attributes['phone']            = '';
        $attributes['email']            = '';
        $attributes['ioh_connect']      = 0;
        $attributes['terms_agreed']     = 0;
        $attributes['event_status_id']  = 1;
        /**
         * 
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->bigInteger('school_id')->nullable();
            $table->integer('graduated_year')->nullable();
            $table->bigInteger('country_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->bigInteger('event_status_id')->nullable();
         */
        return $attributes;
    }

    public function school()
    {
        return $this->hasOne('App\School', 'id', 'school_id')->first();
    }

    public function country()
    {
        return $this->hasOne('App\Country', 'id', 'country_id')->first();
    }

    public function event_status()
    {
        return $this->hasOne('App\AlumniEventStatus', 'id', 'event_status_id')->first();
    }
}
