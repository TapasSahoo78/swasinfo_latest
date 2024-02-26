<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name')->nullable();
            $table->string('title')->nullable()->comment('Title can be used to show a product main heading');
            $table->string('slug')->unique()->nullable();
            $table->longtext('description')->nullable()->comment('Product description');
            $table->foreignId('category_id')->unsigned()->references('id')->on('categories');
            // $table->foreignId('brand_id')->unsigned()->references('id')->on('brands');
            $table->foreignId('vendor_id')->references('id')->on('users')->nullable()->comment('used for vendor tracking');
            $table->double('price')->nullable();
            $table->double('discount')->nullable();
            $table->enum('is_featured', ['no', 'yes'])->default('no');
            $table->boolean('is_active')->default(true)->comment('0 for deactive,1 for active');
            $table->timestamps();
            $table->foreignId('created_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking');
            $table->foreignId('updated_by')->references('id')->on('users')->nullable()->comment('used for updated by user tracking');
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
        Schema::dropIfExists('products');
    }
}
