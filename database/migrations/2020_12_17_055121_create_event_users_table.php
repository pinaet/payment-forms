<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * user(id, name, email, password)
         * event_user(id, user_id, event_id)
         */
        Schema::create('event_users', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->primary('id'); 
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('event_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_users');
    }
}
