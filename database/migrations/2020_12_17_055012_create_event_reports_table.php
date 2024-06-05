<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\EventReport;

class CreateEventReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* event_reports(id, event_id, sql)
        */
        Schema::create('event_reports', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->primary('id'); 
            $table->bigInteger('event_id')->nullable();
            $table->string('sql')->nullable();
            $table->timestamps();
        });

        $sql = "ALTER TABLE event_reports ALTER COLUMN sql NVARCHAR(MAX)"; 
        DB::statement($sql);

        $attributes['id']       = '1001';
        $attributes['event_id'] = '100014';
        $attributes['sql']      = "
        select distinct
            eo.reference_order      'Reference Order',
            eo.contact_name         'Contact Name',
            eo.phone                'Phone Number',
            eo.email                'Email',
            eo.ref1                 'Name & Email of additional attendees',
            et.name					'Ticket Name',
            et.price				'Ticket Price',
            eo.ref2                 '#Tickets',
            eo.amount               'Amount',
            eo.currency             'Currency',
            eo.source_type          'Source Type',
            eo.paid                 'Paid'
        from event_orders eo
            inner join events e on e.id=eo.event_id 
            inner join event_tickets et on et.event_id=eo.event_id and et.id=eo.event_ticket_id
        where 
            eo.paid=1 and eo.event_id=100014
        ";
        EventReport::create( $attributes );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_reports');
    }
}
