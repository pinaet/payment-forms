<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToAlumniTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->bigInteger('event_status_id')->nullable(); //“Registered”, “Reminder Sent”, “Going”, “Not Going”, “Attended”, “Not Attended”
        });
        $sql = 'update alumni set event_status_id=1';
        DB::statement( $sql );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alumni', function (Blueprint $table) {
            $table->dropColumn(['event_status_id']);
        });
    }
}
