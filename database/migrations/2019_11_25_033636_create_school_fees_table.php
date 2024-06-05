<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\SchoolFee;

class CreateSchoolFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contact_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('reference_order')->nullable();
            $table->string('ref')->nullable();
            $table->string('student_code')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('currency', 3)->default('THB');
            $table->string('source_type')->nullable();
            $table->tinyInteger('paid')->default(0);//0=unpaid, 1=paid
            $table->timestamps();
        });
        
        /** set auto increment to start at 10010000 */
        DB::unprepared('SET IDENTITY_INSERT school_fees ON');
        DB::table('school_fees')->insert(['id' => 1001000 ]);
        DB::table('school_fees')->where('id', 1001000)->delete();
        DB::unprepared('SET IDENTITY_INSERT school_fees OFF');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_fees');
    }
}
