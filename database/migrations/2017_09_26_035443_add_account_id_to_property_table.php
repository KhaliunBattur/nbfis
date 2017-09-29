<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccountIdToPropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property', function (Blueprint $table) {
            $table->dropForeign('property_group_id_foreign');
            $table->dropColumn('group_id');
            $table->integer('account_id')->after('id')->index()->unsigned();
            $table->foreign('account_id')->references('id')->on('account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property', function (Blueprint $table) {
            $table->dropColumn('account_id');
            $table->integer('group_id')->index()->unsigned();
            $table->foreign('group_id')->references('id')->on('account_group');
        });
    }
}
