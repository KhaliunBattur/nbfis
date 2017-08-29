<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonCurrencyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season_currency', function (Blueprint $table) {
            $table->integer('season_id')->index()->unsigned();
            $table->integer('currency_id')->index()->unsigned();
            $table->decimal('exchange', 18, 2);

            $table->foreign('season_id')->references('id')->on('season')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currency');
            $table->primary(['season_id', 'currency_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('season_currency');
    }
}
