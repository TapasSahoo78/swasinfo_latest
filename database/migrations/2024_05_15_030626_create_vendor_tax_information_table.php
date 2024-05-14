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
        Schema::create('vendor_tax_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('tax_type')->nullable();

            $table->string('gst_number')->nullable();
            $table->string('cin_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('country')->nullable();
            $table->string('re_pan_number')->nullable();
            $table->string('street_number')->nullable();
            $table->string('apartment_number')->nullable();

            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();

            $table->string('is_signature')->nullable();
            $table->string('signature')->nullable();
            $table->string('signature_date')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
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
        Schema::dropIfExists('vendor_tax_information');
    }
};
