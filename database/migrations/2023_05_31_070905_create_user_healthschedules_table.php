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
        Schema::create('user_healthschedules', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->unsigned()->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->string('sleep_schedule')->nullable();
            $table->string('total_sleep_hours')->nullable();
            $table->string('is_followed_diet_plan')->nullable();
            $table->string('diet_plan_last_time')->nullable();
            $table->string('is_followed_exercise_plan')->nullable();
            $table->string('exercise_plan_last_time')->nullable();
            $table->tinyInteger('any_physical_movement')->comment('0:No,1:Yes')->nullable();
            $table->string('physical_movement_last_time')->nullable();
            $table->string('water_intake_last_time')->nullable();
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
        Schema::dropIfExists('user_healthschedules');
    }
};
