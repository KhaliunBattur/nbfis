<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreColumnToReceivable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivable', function (Blueprint $table) {
            $table->date('start_date')->after('customer_id');
            $table->boolean('is_closed')->after('closing_date')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivable', function (Blueprint $table) {
            $table->dropColumn(['start_date', 'is_closed']);
        });
    }
}
