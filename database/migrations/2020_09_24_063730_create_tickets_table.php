<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Ticket;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('endpoint_id')->nullable();
            $table->string('endpoint_name')->nullable();      
            $table->decimal('endpoint_value', 8, 2)->nullable()->default(0.0);
            $table->decimal('endpoint_fee', 8, 2)->nullable()->default(0.0);
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        $sql = "ALTER TABLE tickets ALTER COLUMN notes NVARCHAR(MAX)";
        DB::statement($sql);

        $this->insert();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }

    public function insert()
    {
        Ticket::truncate();

        //id=1
        $attributes['endpoint_id']    = 2;
        $attributes['endpoint_name']  = 'School Fee';
        $attributes['endpoint_value'] = 0;
        $attributes['endpoint_fee']   = 0;
        Ticket::create( $attributes );
        
        //id=1
        $attributes['endpoint_id']    = 3;
        $attributes['endpoint_name']  = 'Application Fee';
        $attributes['endpoint_value'] = 5000;
        $attributes['endpoint_fee']   = 0;
        Ticket::create( $attributes );
    }
}
