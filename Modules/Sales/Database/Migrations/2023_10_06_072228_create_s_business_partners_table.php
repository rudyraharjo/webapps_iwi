<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSBusinessPartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_business_partners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('business_partner_group_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('shipment_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->string('code')->nullable();
            $table->string('old_code')->nullable();
            $table->string('name')->nullable();
            $table->boolean('activated_status');
            $table->date('periode_start')->nullable();
            $table->date('periode_end')->nullable();
            $table->string('phone_01')->nullable();
            $table->string('phone_02')->nullable();
            $table->string('handphone')->nullable();
            $table->string('email')->nullable();
            $table->longText('noted')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('s_business_partners_address_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_partner_id');
            $table->unsignedBigInteger('province_id')->nullable();
            $table->foreign('province_id')->references('id')->on('c_provinces')->onDelete('cascade');
            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')->on('c_cities')->onDelete('cascade');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('c_countries')->onDelete('cascade');
            $table->integer('type_address_id')->default(1)->comment('1=bill; 2=ship; 3=pay;');
            $table->boolean('set_as_default');
            $table->string('code')->nullable();
            $table->string('zip_code', 5)->nullable();
            $table->longText('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('s_business_partner_contact_people', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->unsignedBigInteger('business_partner_id');
            $table->unsignedBigInteger('designation_id');
            $table->string('name')->nullable();
            $table->longText('address')->nullable();
            $table->string('phone_01')->nullable();
            $table->string('phone_02')->nullable();
            $table->string('handphone')->nullable();
            $table->string('email')->nullable();
            $table->longText('noted')->nullable();
            $table->boolean('activated_status');
            $table->boolean('set_as_default');
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
        Schema::dropIfExists('s_business_partners');
        Schema::dropIfExists('s_business_partners_address_details');
        Schema::dropIfExists('s_business_partner_contact_people');
    }
}
