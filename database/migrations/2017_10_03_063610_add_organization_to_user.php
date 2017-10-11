<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrganizationToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     *      */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('founding_date')->after('register')->nullable()->default(null);
            $table->string('org_type')->after('founding_date')->nullable()->default(null);
            $table->string('org_register')->after('org_type')->nullable()->default(null);
            $table->string('state_num')->after('org_register')->nullable()->default(null);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('founding_date');
            $table->dropColumn('org_type');
            $table->dropColumn('org_register');
            $table->dropColumn('state_num');
        });
    }
}
