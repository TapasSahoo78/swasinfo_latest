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
        Schema::create('gym_trainer_personal_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('gym_name');
            $table->string('owner_name')->comment('User first and last name');
            $table->string('alter_mobile_number')->nullable();
            $table->string('gym_logo')->nullable();
            $table->string('profile_img')->nullable()->comment('User profile picture');
            $table->string('bank_name')->nullable();
            $table->string('account_holder_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('cancel_cheque')->nullable();
            $table->string('pan_holder_name')->nullable();
            $table->string('pan_number')->nullable();
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
        Schema::dropIfExists('gym_trainer_personal_details');
    }
};
