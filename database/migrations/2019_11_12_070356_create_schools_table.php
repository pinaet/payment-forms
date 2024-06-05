<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\School;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('school')->nullable();
            $table->timestamps();
        });

        $attributes['school'] = 'Harrow International School Bangkok';        School::create($attributes);
        
        $attributes['school'] = 'Harrow International School Beijing';        School::create($attributes);

        $attributes['school'] = 'Harrow International School Hong Kong';      School::create($attributes);

        $attributes['school'] = 'Harrow International School Shanghai';       School::create($attributes);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
