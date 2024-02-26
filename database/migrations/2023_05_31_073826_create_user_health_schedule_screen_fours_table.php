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
        Schema::create('user_health_schedule_screen_fours', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->unsigned()->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->tinyInteger('do_you_take_any_medication')->comment('0:No,1:Yes')->nullable();
            $table->tinyInteger('have_you_been_recently_hospitalized')->comment('0:No,1:Yes')->nullable();
            $table->tinyInteger('do_you_suffer_from_asthma')->comment('0:No,1:Yes')->nullable();
            $table->tinyInteger('do_you_have_high_uric_acid')->comment('0:No,1:Yes')->nullable();
            $table->tinyInteger('do_you_have_diabities')->comment('0:No,1:Yes')->nullable();
            $table->tinyInteger('do_you_have_high_cholesterol')->comment('0:No,1:Yes')->nullable();
            $table->tinyInteger('do_you_suffer_from_high_or_low_blood_pressure')->comment('0:No,1:Yes')->nullable();
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
        Schema::dropIfExists('user_health_schedule_screen_fours');
    }
};
