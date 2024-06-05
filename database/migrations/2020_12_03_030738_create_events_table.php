<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Event;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigInteger('id');
            $table->primary('id');
            $table->string('name')->nullable();      
            $table->string('website')->nullable();
            $table->string('footnote')->nullable();
            $table->string('bcc')->nullable();
            $table->string('organizer')->nullable();
            $table->bigInteger('gate_endpoint_id')->nullable();
            $table->timestamps();
        });        

        $sql = "ALTER TABLE events ALTER COLUMN footnote NVARCHAR(MAX)";
        DB::statement($sql);

        $sql = "ALTER TABLE events ALTER COLUMN organizer NVARCHAR(MAX)";
        DB::statement($sql);

        $attributes['id']               = '100014';
        $attributes['name']             = 'OFFSEAS 2021';
        $attributes['website']          = 'https://offseas.squarespace.com/';
        $attributes['footnote']         = 'Thank you for your registration for OFFSEAS 2021. Please do not hesitate to contact us at <a href="mailto:">admin@offseas.org</a> should you have any questions prior to the event. We look forward to seeing you in May!';
        $attributes['bcc']              = 'admin@offseas.org';
        $attributes['organizer']        = 'Liam Warren (Operations Compliance Manager) <liam_wa@harrowschool.ac.th>, Timothy Chappell (Operations Manager) <tim_ch@harrowschool.ac.th>, Christina Thorsen <christina@smartcookies.io>,Liam Warren (Operations Compliance Manager) <liam_wa@harrowschool.ac.th>, Timothy Chappell (Operations Manager) <tim_ch@harrowschool.ac.th>, Christina Thorsen <christina@smartcookies.io>, admin@offseas.org';
        $attributes['gate_endpoint_id'] = 5;
        Event::create( $attributes );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
