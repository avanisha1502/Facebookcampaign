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
        Schema::table('campaign_all_details', function (Blueprint $table) {
            $table->string('topic_name')->after('id');
            $table->string('strategy')->after('topic_name')->nullable();
            $table->string('pixel')->after('strategy')->nullable();
            $table->string('feed_provide')->after('pixel')->nullable();
            $table->string('custom_field')->after('feed_provide')->nullable();
            $table->text('description')->after('primary_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_all_details', function (Blueprint $table) {
            $table->dropColumn('topic_name');
            $table->dropColumn('strategy');
            $table->dropColumn('pixel');
            $table->dropColumn('feed_provide');
            $table->dropColumn('custom_field');
            $table->dropColumn('description');
        });
    }
};
