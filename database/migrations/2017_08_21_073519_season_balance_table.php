<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeasonBalanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_balance', function (Blueprint $table) {
            $table->integer('season_id')->index()->unsigned();
            $table->integer('account_id')->index()->unsigned();
            $table->decimal('exchange', 18, 2);
            $table->decimal('balance', 18, 2);

            $table->foreign('season_id')->references('id')->on('season')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('account_id')->references('id')->on('account');
            $table->primary(['season_id', 'account_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('season_balance');
    }
}
