<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->bigInteger('table_id')->unsigned();
            $table->morphs('addressable');
            $table->longText('street_address')->nullable();
            $table->longText('full_address')->nullable();
            $table->string('address_type')->comment('user,branch')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country_name')->nullable();
            $table->string('state_name')->nullable();
            $table->string('city_name')->nullable();
            $table->string('landmark')->nullable();
            $table->string('zone_id')->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
