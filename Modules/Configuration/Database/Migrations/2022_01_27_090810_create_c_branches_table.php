<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_branches', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('c_countries');
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('id')->on('c_provinces');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('c_cities');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('c_districts');
            $table->unsignedBigInteger('village_id');
            $table->foreign('village_id')->references('id')->on('c_villages');
            $table->string('code', 20);
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_branches');
    }
}
