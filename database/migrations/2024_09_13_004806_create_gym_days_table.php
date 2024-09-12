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
// <<<<<<<< HEAD:database/migrations/2024_09_13_004806_create_gym_days_table.php
        Schema::create('gym_days', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->boolean('is_active')->default(true);
// ========
        // Schema::create('contac_us', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('fisrt_name');
        //     $table->string('last_name');
        //     $table->string('connecting_for');
        //     $table->string('mobile');
        //     $table->string('email');
        //     $table->string('details');
// >>>>>>>> 5278a15d54d297b514d5e419999275e8d42c3132:database/migrations/2024_03_22_003353_create_contac_us_table.php
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
        Schema::dropIfExists('gym_days');

        // Schema::dropIfExists('contac_us');
    }
};
