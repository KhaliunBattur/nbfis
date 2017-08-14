<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset', function (Blueprint $table) {
            $table->string('asset_type')->after('asset')->nullable()->default(null);
            $table->integer('asset_type_id')->after('asset_type')->nullable()->default(null);
            $table->text('description')->after('asset_type_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset', function (Blueprint $table) {
            $table->dropColumn('asset_type');
            $table->dropColumn('asset_type_id');
            $table->dropColumn('description');
        });
    }
}
