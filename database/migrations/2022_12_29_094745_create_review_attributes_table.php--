<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->references('id')->on('reviews')->onDelete('cascade');
            $table->string('name', 100)->nullable();
            $table->double('rating', 1, 1);
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
        Schema::dropIfExists('review_attributes');
    }
}
