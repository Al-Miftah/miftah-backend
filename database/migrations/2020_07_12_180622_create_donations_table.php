<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class CreateDonationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('success'); 
            $table->string('gateway')->comment('Any payment gateway like stripe, paystack, bank name etc' );
            $table->string('transaction_reference');
            $table->unsignedBigInteger('amount')->comment('Store in lowest denomation');
            $table->string('currency');
            $table->string('channel')->comment('Any of the following: card, mobile_money, bank, cash');
            $table->string('payment_type')->comment('onetime, monthly etc');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Nullable for anonymous donors');
            $table->unsignedBigInteger('organization_id');
            $table->text('additional_information')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
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
        Schema::dropIfExists('donations');
    }
}
