<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Event;

class UpdateEventsAndEventOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('consent_1')->nullable();
            $table->string('consent_2')->nullable();
            $table->string('consent_3')->nullable();
            $table->string('consent_4')->nullable();
            $table->tinyInteger('consent_1_required')->nullable();//0=no, 1=yes
            $table->tinyInteger('consent_2_required')->nullable();//0=no, 1=yes
            $table->tinyInteger('consent_3_required')->nullable();//0=no, 1=yes
            $table->tinyInteger('consent_4_required')->nullable();//0=no, 1=yes
        });        

        $sql = "ALTER TABLE events ALTER COLUMN consent_1 NVARCHAR(MAX)"; 
        DB::statement($sql);
        $sql = "ALTER TABLE events ALTER COLUMN consent_2 NVARCHAR(MAX)"; 
        DB::statement($sql);
        $sql = "ALTER TABLE events ALTER COLUMN consent_3 NVARCHAR(MAX)"; 
        DB::statement($sql);
        $sql = "ALTER TABLE events ALTER COLUMN consent_4 NVARCHAR(MAX)";
        DB::statement($sql);

        $event = Event::find(100014);
        $event['consent_1'] = 'I understand by ticking this box that my details will be stored by the OFFSEAS committee for the purpose of communicating information relating to the OFFSEAS conference.';
        $event['consent_2'] = 'I understand by ticking this box I am happy to receive email notifications of media updates through the OFFSEAS website.';
        $event['consent_3'] = 'I understand by ticking this box, that I am happy for my email address to be given to providers and sponsors who attend the OFFSEAS conference and for them to contact me. I understand OFFSEAS are not responsible for how providers and sponsors may then manage my personal details.';
        $event['consent_4'] = 'I understand by ticking this box, that I am happy for photos and images taken at the conference to be used in promotional material on the OFFSEAS website and event marketing.';
        $event->save();


        Schema::table('event_orders', function (Blueprint $table) {
            $table->tinyInteger('consent_3')->nullable();//0=no, 1=yes
            $table->tinyInteger('consent_4')->nullable();//0=no, 1=yes
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('consent_1');
            $table->dropColumn('consent_2');
            $table->dropColumn('consent_3');
            $table->dropColumn('consent_4');
            $table->dropColumn('consent_1_required');
            $table->dropColumn('consent_2_required');
            $table->dropColumn('consent_3_required');
            $table->dropColumn('consent_4_required');
        }); 

        Schema::table('event_orders', function (Blueprint $table) {
            $table->dropColumn('consent_3');
            $table->dropColumn('consent_4');
        }); 
    }
}
