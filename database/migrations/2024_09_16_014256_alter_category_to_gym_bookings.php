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
        Schema::table('gym_bookings', function (Blueprint $table) {
            $table->unsignedBigInteger('gym_category_id')->after('user_id')->nullable();
            $table->foreign('gym_category_id')->references('id')->on('gym_categories')->onDelete('cascade');
            $table->string('timing')->nullable()->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gym_bookings', function (Blueprint $table) {
            $table->dropColumn(['gym_category_id', 'timing']);
        });
    }
};
