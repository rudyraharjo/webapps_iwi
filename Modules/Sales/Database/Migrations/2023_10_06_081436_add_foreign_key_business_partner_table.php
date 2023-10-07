<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeyBusinessPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('s_business_partners', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('c_business_partner_categories')->onDelete('cascade');
            $table->foreign('designation_id')->references('id')->on('c_designation')->onDelete('cascade');
            $table->foreign('business_partner_group_id')->references('id')->on('c_business_partner_groups')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('c_currencies')->onDelete('cascade');
            $table->foreign('shipment_id')->references('id')->on('c_shipments')->onDelete('cascade');
            $table->foreign('province_id')->references('id')->on('c_provinces')->onDelete('cascade');
        });

        Schema::table('s_business_partners_address_details', function (Blueprint $table) {
            $table->foreign('business_partner_id')->references('id')->on('s_business_partners')->onDelete('cascade');
        });

        Schema::table('s_business_partner_contact_people', function (Blueprint $table) {
            $table->foreign('business_partner_id')->references('id')->on('s_business_partners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('s_business_partners', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['designation_id']);
            $table->dropForeign(['business_partner_group_id']);
            $table->dropForeign(['currency_id']);
            $table->dropForeign(['shipment_id']);
            $table->dropForeign(['province_id']);
            $table->dropForeign(['bill_to_address_id']);
            $table->dropForeign(['ship_to_address_id']);
            $table->dropForeign(['pay_to_address_id']);
        });

        Schema::table('s_business_partners_address_details', function (Blueprint $table) {
            $table->dropForeign(['business_partner_id']);
            $table->dropForeign(['designation_id']);
        });

        Schema::table('s_business_partner_contact_people', function (Blueprint $table) {
            $table->dropForeign(['business_partner_id']);
        });
    }
}
