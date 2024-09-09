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
        Schema::create('gym_booking_attandances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gym_booking_id');
            $table->foreign('gym_booking_id')->references('id')->on('gym_bookings')->onDelete('cascade');
            $table->string('date_time')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('gym_booking_attandances');
    }
};
