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
        Schema::create('gym_management', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->json('gym_category_ids')->nullable()->comment('Array of gym category IDs');
            $table->json('days')->nullable()->comment('Array of days');
            $table->string('closing_day')->nullable();
            $table->longText('about_us')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->json('facilities')->nullable()->comment('Array of facilities');
            $table->string('city')->nullable();
            $table->longText('location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('create_by')->nullable();
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
        Schema::dropIfExists('gym_management');
    }
};
