<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id')->index()->unsigned();
            $table->integer('branch_id')->index()->unsigned()->nullable()->default(null);
            $table->string('code');
            $table->string('name');
            $table->integer('owner_id')->index()->unsigned()->nullable()->default(null);
            $table->decimal('unit_amount', 18, 2);
            $table->decimal('count', 18, 2);
            $table->date('start_date');
            $table->double('use_time_count', 18, 2);
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('account_group');
            $table->foreign('branch_id')->references('id')->on('branch');
            $table->foreign('owner_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property');
    }
}
