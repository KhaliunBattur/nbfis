<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLoanRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('loan_request', function (Blueprint $table) {
            $table->string('pledge_type')->after('user_id')->nullable()->default(null);
            $table->integer('pledge_type_id')->after('pledge_type')->nullable()->default(null);
            $table->text('description')->after('expire_date')->nullable()->default(null);
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
            $table->dropColumn('pledge_type');
            $table->dropColumn('pledge_type_id');
            $table->dropColumn('description');
        });
    }
}
