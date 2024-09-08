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
        Schema::create('restaurants_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name', 100)->comment('Category Name');
            $table->string('slug')->comment('Category Slug');
            $table->foreignId('category_id')->references('id')->on('restaurants_categories')->comment('for master restaurants_categories')->nullable()->default(NULL);
            $table->longText('description')->nullable()->comment('Category Description');
            $table->boolean('is_active')->default(true)->comment('0 for deactive,1 for active');
            $table->foreignId('created_by')->nullable()->references('id')->on('users')->comment('used for created by user tracking');
            $table->foreignId('updated_by')->nullable()->references('id')->on('users')->comment('used for created by user tracking');
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
        Schema::dropIfExists('restaurants_sub_categories');
    }
};
