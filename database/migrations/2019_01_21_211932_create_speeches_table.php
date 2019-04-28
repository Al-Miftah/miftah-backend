<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpeechesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speeches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('speaker_id');
            $table->unsignedInteger('topic_id')->nullable();
            $table->unsignedInteger('language_id');
            $table->string('title');
            $table->string('slug');
            $table->text('summary')->nullable();
            $table->text('url');

            $table->foreign('topic_id')->references('id')->on('topics')->onDelete('cascade');
            $table->foreign('speaker_id')->references('id')->on('speakers')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('speeches');
    }
}
