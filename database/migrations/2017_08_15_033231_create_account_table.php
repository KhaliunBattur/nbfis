<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->index()->unsigned();
            $table->string('code');
            $table->string('account_number')->unique();
            $table->string('name');
            $table->integer('currency_id')->index()->unsigned();
            $table->integer('journal_id')->index()->unsigned()->nullable()->default(null);
            $table->enum('type', ['active', 'passive'])->default('active');
            $table->boolean('is_temporary')->default(false);
            $table->integer('bank_id')->index()->unsigned()->nullable()->default(null);
            $table->string('bank_account_number')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('account_group');
            $table->foreign('currency_id')->references('id')->on('currency');
            $table->foreign('journal_id')->references('id')->on('journal');
            $table->foreign('bank_id')->references('id')->on('bank');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account');
    }
}
