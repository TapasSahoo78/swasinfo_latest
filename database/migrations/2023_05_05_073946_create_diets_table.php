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
        Schema::create('diets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->json('gender')->nullable();
            $table->string('age_from')->nullable();
            $table->string('age_to')->nullable();
            $table->decimal('height_from',12,2)->nullable();
            $table->decimal('height_to',12,2)->nullable();
            $table->decimal('weight_from',12,2)->nullable();
            $table->decimal('weight_to',12,2)->nullable();
            $table->decimal('bmi_from', 12,2)->nullable();
            $table->decimal('bmi_to', 12,2)->nullable();
            $table->json('goal')->nullable();
            $table->json('diet')->nullable();
            $table->json('medical_condition')->nullable();
            $table->json('allergy')->nullable();
            $table->decimal('breakfast_calories',12,2)->nullable();
            $table->decimal('lunch_calories',12,2)->nullable();
            $table->decimal('snack_calories',12,2)->nullable();
            $table->decimal('dinner_calories',12,2)->nullable();
            $table->decimal('carbs',12,2)->nullable();
            $table->decimal('proteins',12,2)->nullable();
            $table->decimal('fats',12,2)->nullable();
            $table->decimal('fibres',12,2)->nullable();
            $table->tinyInteger('status')->default('1')->comment('0:Inactive,1:Active,3:deleted')->nullable();
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
        Schema::dropIfExists('diets');
    }
};
