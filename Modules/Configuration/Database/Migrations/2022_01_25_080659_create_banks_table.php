<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_banks', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20);
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('c_banks')->insert(
            array(
                array('name' => 'Bank Central Asia', 'code' => 'BCA'),
                array('name' => 'Bank Negara Indonesia', 'code' => 'BNI'),
                array('name' => 'Bank Republik Indonesia', 'code' => 'BRI'),
                array('name' => 'Bank Mandiri', 'code' => 'Mandiri')
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }
}
