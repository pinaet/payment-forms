<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** OpenApply */
        Schema::create('application_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('endpoint_id')->nullable();  //get this id from the 'gate' project
            $table->string('student_name')->nullable();     //contact_name
            $table->string('parent_name')->nullable();      //phone
            $table->string('parent_email')->nullable();     //email
            $table->string('payment_type')->nullable();     //
            $table->string('applicant_id')->nullable();     //reference_order
            $table->string('ref')->nullable();              //student_id.ref
            $table->decimal('fee_amount', 10, 2)->nullable();
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->string('currency', 3)->default('THB');
            $table->string('source_type')->nullable();      //card, unionpay, wechat, alipay
            $table->tinyInteger('paid')->default(0);        //0=unpaid, 1=paid
            $table->timestamps();
        });
        
        /** set auto increment to start at 10020000 */
        DB::unprepared('SET IDENTITY_INSERT application_fees ON');
        DB::table('application_fees')->insert(['id' => 10020000 ]);
        DB::table('application_fees')->where('id', 10020000)->delete();
        DB::unprepared('SET IDENTITY_INSERT application_fees OFF');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_fees');
    }
}
