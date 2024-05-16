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
        Schema::create('vendor_account_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('card_number');
            $table->string('valid_month');
            $table->string('valid_yaer');
            $table->text('card_holder');
            $table->text('bank_location');
            $table->text('account_holder');
            $table->text('ifsc_code');
            $table->text('bank_account_number');
            $table->text('re_account_number');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('vendor_account_information');
    }
};
