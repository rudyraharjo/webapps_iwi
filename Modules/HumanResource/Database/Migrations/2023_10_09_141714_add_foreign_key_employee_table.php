<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_job_positions', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });

        Schema::table('hr_employees', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_job_positions', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });

        Schema::table('hr_employees', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
}
