<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeechTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speech_tag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('speech_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('speech_id')->references('id')->on('speeches')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('speech_tag');
    }
}
