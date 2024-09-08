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
        Schema::create('restaurant_media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('user_id')->unsigned()->references('id')->on('users');
            $table->foreignId('restaurant_id')->nullable()->unsigned()->references('id')->on('restaurants');
            $table->morphs('mediaable');

            $table->string('media_type')->comment('Please add document or image description in this field');
            $table->string('reference_type')->comment('Please add document or image description in this field')->nullable();

            $table->string('file');
            $table->boolean('is_restaurants_picture')->default(0)->comment('0 = No, 1 = Yes');
            $table->boolean('is_logo')->default(0)->comment('0 = No, 1 = Yes');
            $table->boolean('is_menu')->default(0)->comment('0 = No, 1 = Yes');
            $table->boolean('is_item')->default(0)->comment('0 = No, 1 = Yes');
            $table->boolean('is_offer')->default(0)->comment('0 = No, 1 = Yes');
            $table->boolean('is_location')->default(0)->comment('0 = No, 1 = Yes');
            $table->json('meta_details')->nullable()->comment('Meta details are use for advertisement and seo purpose');
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
        Schema::dropIfExists('restaurant_media');
    }
};
