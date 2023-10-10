<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_job_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('team_id')->nullable();
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('hr_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('job_position_id')->nullable();
            $table->string('nik')->nullable();
            $table->string('fullname')->nullable();
            $table->string('avatar')->nullable();
            $table->string('birth_place')->nullable();
            $table->boolean('activated_status');
            $table->date('birth_date')->nullable();
            $table->date('hire_date')->nullable();
            $table->char('gender')->nullable();
            $table->string('phone_02')->nullable();
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
        Schema::dropIfExists('hr_job_positions');
        Schema::dropIfExists('hr_employees');
    }
}
