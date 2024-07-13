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
        Schema::table('trainer_details', function (Blueprint $table) {
            $table->string('profile_photo')->nullable()->after('experience');
            $table->string('trans_photo_one')->nullable()->after('profile_photo');
            $table->string('trans_photo_two')->nullable()->after('trans_photo_one');
            $table->string('trans_photo_three')->nullable()->after('trans_photo_two');
            $table->string('trans_photo_four')->nullable()->after('trans_photo_three');
            $table->string('trans_photo_five')->nullable()->after('trans_photo_four');

            $table->longText('address')->nullable()->after('trans_photo_four');

            $table->string('slot_day')->nullable()->after('address');
            $table->string('from_time')->nullable()->after('slot_day');
            $table->string('to_time')->nullable()->after('from_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trainer_details', function (Blueprint $table) {
            //
        });
    }
};
