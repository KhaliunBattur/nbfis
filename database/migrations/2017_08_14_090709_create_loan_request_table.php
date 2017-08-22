<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->decimal('loan_term', 18, 2);
            $table->date('period_time');
            $table->integer('payment_day');
            $table->string('loanable')->nullable()->default(null);
            $table->integer('loanable_id')->nullable()->default(null);
            $table->date('expire_date')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_request');
    }
}
