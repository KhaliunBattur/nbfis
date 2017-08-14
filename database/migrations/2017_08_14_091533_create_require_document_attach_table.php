<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequireDocumentAttachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('required_document_attach', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('required_document_id')->index()->unsigned();
            $table->string('path');
            $table->timestamps();

            $table->foreign('required_document_id')->references('id')->on('required_document')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('required_document_attach');
    }
}
