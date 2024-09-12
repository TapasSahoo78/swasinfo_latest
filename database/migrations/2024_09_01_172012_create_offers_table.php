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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name', 255)->nullable();
            $table->string('type', 255)->nullable();
            $table->string('price', 255)->nullable();
            $table->string('persantage', 255)->nullable();
            $table->string('start_date', 255)->nullable();
            $table->string('end_date', 255)->nullable();
            $table->tinyInteger('status')->default('1')->comment('0:Inactive,1:Active,3:deleted')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('offers');
    }
};
