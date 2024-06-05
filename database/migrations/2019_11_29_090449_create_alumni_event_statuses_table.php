<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\AlumniEventStatus;

class CreateAlumniEventStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumni_event_statuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event_status')->nullable();
            $table->timestamps();
        });

        // $attributes['event_status'] = 'Registered';
        // AlumniEventStatus::create( $attributes );
        AlumniEventStatus::create( ['event_status'=>'Registered'    ] );
        AlumniEventStatus::create( ['event_status'=>'Reminder Sent' ] );
        AlumniEventStatus::create( ['event_status'=>'Going'         ] );
        AlumniEventStatus::create( ['event_status'=>'Not Going'     ] );
        AlumniEventStatus::create( ['event_status'=>'Attended'      ] );
        AlumniEventStatus::create( ['event_status'=>'Not Attended'  ] );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumni_event_statuses');
    }
}
