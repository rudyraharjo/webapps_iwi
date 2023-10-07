<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_company', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('id')->on('c_provinces');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('c_cities');
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('c_districts');
            $table->unsignedBigInteger('village_id');
            $table->foreign('village_id')->references('id')->on('c_villages');
            $table->string('code', 20);
            $table->string('name', 130);
            $table->string('email');
            $table->string('phone');
            $table->longText('address')->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('logo', 20)->nullable();
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
        Schema::dropIfExists('c_company');
    }
}
