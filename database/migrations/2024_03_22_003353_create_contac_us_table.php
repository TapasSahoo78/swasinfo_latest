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
        Schema::create('contac_us', function (Blueprint $table) {
            $table->id();
            $table->string('fisrt_name');
            $table->string('last_name');
            $table->string('connecting_for');
            $table->string('mobile');
            $table->string('email');
            $table->string('details');
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
        Schema::dropIfExists('contac_us');
    }
};
