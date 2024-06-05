<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\EventTicket;

class CreateEventTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_tickets', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->bigInteger('event_id');
            $table->string('name')->nullable();
            $table->string('price_type', 1)->nullable(); //'t'=ticket  'f'=fixed  'v'=variable
            $table->decimal('price', 8, 2)->nullable()->default(0.0);
            $table->string('currency', 3)->nullable();
            $table->string('number_text')->nullable();
            $table->string('reference_text')->nullable();
            $table->timestamps();

            $table->primary('id');
            // $table->primary(['id', 'event_id']);
            // $table->foreign('event_id')->references('id')->on('events');
        });

        $attributes['id']            = 1011;
        $attributes['event_id']      = 100014;
        $attributes['name']          = 'Gold Onsite Package';
        $attributes['price_type']    = 't';
        $attributes['price']         = 15000;
        $attributes['currency']      = 'THB';
        $attributes['number_text']   = 'Number';
        $attributes['reference_text']= 'Name & Email of additional attendees';
        EventTicket::create($attributes);

        $attributes['id']            = 1012;
        $attributes['event_id']      = 100014;
        $attributes['name']          = 'Silver Online Package';
        $attributes['price_type']    = 't';
        $attributes['price']         = 10000;
        $attributes['currency']      = 'THB';
        $attributes['number_text']   = 'Number';
        $attributes['reference_text']= 'Name & Email of additional attendees';
        EventTicket::create($attributes);

        $attributes['id']            = 1013;
        $attributes['event_id']      = 100014;
        $attributes['name']          = 'In-person Package';
        $attributes['price_type']    = 't';
        $attributes['price']         = 7000;
        $attributes['currency']      = 'THB';
        $attributes['number_text']   = 'Number';
        $attributes['reference_text']= 'Name & Email of additional attendees';
        EventTicket::create($attributes);

        $attributes['id']            = 1014;
        $attributes['event_id']      = 100014;
        $attributes['name']          = 'Online Package';
        $attributes['price_type']    = 't';
        $attributes['price']         = 4500;
        $attributes['currency']      = 'THB';
        $attributes['number_text']   = 'Number';
        $attributes['reference_text']= 'Name & Email of additional attendees';
        EventTicket::create($attributes);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_tickets');
    }
}
