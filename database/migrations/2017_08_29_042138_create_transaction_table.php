<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('season_id')->index()->unsigned();
            $table->string('receipt_number')->nullable()->default(null);
            $table->date('transaction_date')->nullable()->default(null);
            $table->integer('customer_id')->index()->unsigned()->nullable()->default(null);
            $table->integer('account_id')->index()->unsigned();
            $table->integer('to_account_id')->index()->unsigned()->nullable()->default(null);
            $table->text('description');
            $table->decimal('amount', 18, 2);
            $table->decimal('exchange', 18, 2);
            $table->enum('type', ['credit', 'debit'])->nullable()->default(null);
            $table->string('transaction_able')->nullable()->default(null);
            $table->integer('transaction_able_id')->nullable()->default(null);
            $table->integer('user_id')->index()->unsigned();
            $table->timestamps();

            $table->foreign('season_id')->references('id')->on('season');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('account_id')->references('id')->on('account');
            $table->foreign('to_account_id')->references('id')->on('account');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
