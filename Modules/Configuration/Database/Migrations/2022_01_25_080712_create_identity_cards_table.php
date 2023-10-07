<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateIdentityCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_identity_cards', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20);
            $table->string('name', 130);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('c_identity_cards')->insert(
            array(
                array('name' => 'Kartu Tanda Penduduk', 'code' => 'KTP'),
                array('name' => 'Surat Izin Mengemudi', 'code' => 'SIM'),
                array('name' => 'Paspor', 'code' => 'Paspor'),
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
        Schema::dropIfExists('c_identity_cards');
    }
}
