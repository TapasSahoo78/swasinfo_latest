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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('plan_category_id')->unsigned()->references('id')->on('plan_categories');
            $table->string('name');
            $table->decimal('price', 12, 2)->nullable()->default(0);
            $table->tinyInteger('status')->default('1')->comment('0:Inactive,1:Active,3:deleted')->nullable();
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
        Schema::dropIfExists('plans');
    }
};
