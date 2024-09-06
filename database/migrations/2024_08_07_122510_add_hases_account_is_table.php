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
        Schema::table('generate_headlines', function (Blueprint $table) {
            $table->text('hashes')->after('images')->nullable();
            $table->text('account_id')->after('campaign_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('generate_headlines', function (Blueprint $table) {
            $table->dropColumn('hashes');
            $table->dropColumn('campaign_id');
        });
    }
};
