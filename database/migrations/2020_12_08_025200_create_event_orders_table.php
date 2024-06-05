<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_orders', function (Blueprint $table) {
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
        });
        
        DB::unprepared('SET IDENTITY_INSERT event_orders ON');
        DB::table('event_orders')->insert(['id' => 10050000 ]);
        DB::table('event_orders')->where('id', 10050000)->delete();
        DB::unprepared('SET IDENTITY_INSERT event_orders OFF');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_orders');
    }
}
