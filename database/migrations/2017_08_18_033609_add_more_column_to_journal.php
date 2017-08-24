<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnToJournal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->string('form_code')->after('name')->nullable()->default(null);
            $table->integer('root_id')->after('form_code')->index()->unsigned()->nullable()->default(null);

            $table->foreign('root_id')->references('id')->on('journal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal', function (Blueprint $table) {
            $table->dropForeign('journal_root_id_foreign');
            $table->dropColumn('root_id');
            $table->dropColumn('form_code');
        });
    }
}
