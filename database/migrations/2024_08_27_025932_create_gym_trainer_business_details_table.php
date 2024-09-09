<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gym_trainer_business_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('have_gst')->default(1);
            $table->text('gst_number')->nullable();
            $table->string('gst_image')->nullable();

            $table->boolean('have_msme')->default(1);
            $table->text('msme_number')->nullable();
            $table->string('msme_image')->nullable();

            $table->boolean('have_shop_certificate')->default(1);
            $table->text('shop_certificate_number')->nullable();
            $table->string('shop_certificate_image')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gym_trainer_business_details');
    }
};
