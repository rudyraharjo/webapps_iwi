<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_units', function (Blueprint $table) {
            $table->id();
            $table->string('code', 130);
            $table->text('description')->nullable();
            $table->boolean('smallest')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('c_units')->insert(
            array(
                array('code' => 'Pcs', 'description' => 'pieces', 'smallest' => true),
                array('code' => 'Pack', 'description' => 'Package', 'smallest' => false),
                array('code' => 'Kg', 'description' => 'Kilogram', 'smallest' => false),
                array('code' => 'each', 'description' => 'Each', 'smallest' => false),
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
        Schema::dropIfExists('c_units');
    }
}
