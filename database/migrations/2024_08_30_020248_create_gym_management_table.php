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
            $table->json('gym_category_ids')->nullable()->comment('Array of gym category IDs');
            $table->string('title');
            $table->string('slug');
            $table->longText('about')->nullable();
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
