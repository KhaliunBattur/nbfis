<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequiredDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('required_document', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('loan_request_id')->index()->unsigned();
            $table->string('document_name');
            $table->integer('page_count')->default(1);
            $table->timestamps();

            $table->foreign('loan_request_id')->references('id')->on('loan_request')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('required_document');
    }
}
