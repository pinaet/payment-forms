<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected   $guarded   = [];

    public function tickets(){
        return $this->hasMany('App\EventTicket','event_id','id');
    }
}
