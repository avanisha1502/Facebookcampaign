<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ad_accounts', function (Blueprint $table) {
            $table->text('pixel_id')->after('default_dsa_beneficiary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_accounts', function (Blueprint $table) {
            $table->dropColumn('pixel_id');
        });
    }
};
