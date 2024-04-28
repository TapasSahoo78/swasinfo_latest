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
        Schema::create('product_brands', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name', 100)->comment('Brand Name');
            $table->string('slug', 100);
            $table->string('brand_image')->nullable();
            $table->longText('description')->nullable()->comment('Brand Description');
            $table->string('origin', 100)->nullable();
            $table->tinyInteger('is_active')->default('1')->comment('0:Inactive,1:Active,2:deleted')->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking');
            $table->foreignId('updated_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking');
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
        Schema::dropIfExists('product_brands');
    }
};
