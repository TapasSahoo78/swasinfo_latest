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
        Schema::create('restaurant_order_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('category_id')->references('id')->on('restaurants_categories')->comment('for master restaurants_categories')->nullable()->default(NULL);
            $table->foreignId('sub_category_id')->references('id')->on('restaurants_sub_categories')->comment('for master restaurants_sub_categories')->nullable()->default(NULL);
            $table->foreignId('restaurant_product_id')->references('id')->on('restaurant_products')->comment('for master restaurant_products')->nullable()->default(NULL);
            $table->foreignId('user_id')->references('id')->on('users')->comment('forusers')->nullable()->default(NULL);
            $table->double('price')->default(0.00)->comment('item/product price');
            $table->double('discount_price')->default(0.00)->comment('item/product discount price');
            $table->boolean('is_discount')->default(0)->comment('0 for no,1 for yes');
            $table->foreignId('restaurant_id')->references('id')->on('restaurants')->comment('for master restaurant')->nullable()->default(NULL);
            $table->foreignId('updated_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking')->default(NULL);
            $table->foreignId('created_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking')->default(NULL);
            $table->boolean('is_active')->default(true)->comment('0 for is_order,1 for resturant order confirm,2 for resturant order cancle');
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
        Schema::dropIfExists('restaurant_order_details');
    }
};
