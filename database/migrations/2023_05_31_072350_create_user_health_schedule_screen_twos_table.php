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
        Schema::create('user_health_schedule_screen_twos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->unsigned()->references('id')->on('users')->constrained()->cascadeOnDelete();
            $table->tinyInteger('do_you_get_tired_during_the_day')->comment('0:No,1:Yes')->nullable();
            $table->tinyInteger('feel_drizzing_when_you_wakeup')->comment('0:No,1:Yes')->nullable();
            $table->string('how_much_do_you_smoke_in_a_day')->nullable();
            $table->string('how_often_do_you_drink')->nullable();
            $table->string('what_do_you_usually_drink')->nullable();
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
        Schema::dropIfExists('user_health_schedule_screen_twos');
    }
};
