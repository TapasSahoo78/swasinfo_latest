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
        Schema::create('profile_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_question_id');
            $table->longText('answer')->nullable();
            $table->longText('input_type')->nullable();
            $table->longText('comments')->nullable();
            $table->foreign('profile_question_id')->references('id')->on('profile_questions')->onDelete('cascade');
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
        Schema::dropIfExists('profile_answers');
    }
};
