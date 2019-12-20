<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowerblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('followerbles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('follower_id');
            $table->unsignedBigInteger('followerble_id');
            $table->string('followerble_type');
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->index(['followerble_id', 'followerble_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followerbles');
    }
}
