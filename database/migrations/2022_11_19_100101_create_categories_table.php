<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name', 100)->comment('Category Name');
            $table->string('slug')->comment('Category Slug');
            $table->unsignedBigInteger('parent_id')->comment('for master category')->nullable()->default(NULL);
            // $table->foreignId('parent_id')->references('id')->on('categories')->comment('for master category')->nullable()->default(NULL);
            $table->longText('description')->nullable()->comment('Category Description');
            $table->boolean('is_active')->default(true)->comment('0 for deactive,1 for active');
            $table->foreignId('created_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking');
            $table->foreignId('updated_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking');
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
        Schema::dropIfExists('categories');
    }
}
