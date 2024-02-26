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
        Schema::create('user_physically_active_conditions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('title', 255)->nullable();
            $table->string('sub_title', 100)->nullable();
            $table->mediumText('description')->nullable();
            $table->boolean('status')->default(true)->comment('0 for deactive,1 for active');
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
        Schema::dropIfExists('user_physically_active_conditions');
    }
};
