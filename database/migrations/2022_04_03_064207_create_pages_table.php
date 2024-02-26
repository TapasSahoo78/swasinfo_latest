<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->longText('description')->nullable();
            /*  $table->string('page_type')->nullable();
            $table->tinyInteger('is_default')->nullable(); */
            $table->tinyInteger('status')->default('1')->comment('0:Inactive,1:Active,3:deleted')->nullable();
            $table->timestamps();
           /*  $table->foreignId('created_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking');
            $table->foreignId('updated_by')->references('id')->on('users')->nullable()->comment('used for created by user tracking'); */
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
        Schema::dropIfExists('pages');
    }
}
