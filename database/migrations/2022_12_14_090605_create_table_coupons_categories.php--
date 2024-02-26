<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCouponsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons_categories', function (Blueprint $table) {
            $table->foreignId('coupon_id')->unsigned()->references('id')->on('coupons')->onDelete('cascade');
            $table->foreignId('category_id')->unsigned()->references('id')->on('categories')->onDelete('cascade');
            $table->primary(['coupon_id','category_id']);
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons_categories');
    }
}
