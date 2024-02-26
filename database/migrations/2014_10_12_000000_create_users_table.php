<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable()->unique()->comment('Users Username');
            $table->string('email')->nullable()->unique();
            $table->tinyInteger('is_password_changed')->default(0)->nullable();
            $table->tinyInteger('is_profile_completed')->default(0)->nullable();
            /* $table->tinyInteger('is_email')->default(0)->nullable(); */
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('mobile_number')->nullable()->unique();
            $table->timestamp('mobile_number_verified_at')->nullable();
            $table->mediumInteger('verification_code')->nullable()->comment('OTP used for verifying the phone number');
            $table->boolean('is_twofactor')->default(false);
            $table->string('two_factor_code', 100)->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->string('registration_ip', 100)->nullable();
            $table->string('last_login_ip', 100)->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->mediumText('notifications')->nullable();
            $table->tinyInteger('is_active')->default('1')->comment('0:Inactive,1:Active,3:deleted')->nullable();
            $table->tinyInteger('is_approve')->default('1')->comment('0:Unapproved,1:Approved')->nullable();
            $table->tinyInteger('is_blocked')->default('0')->comment('0:Unblocked,1:Blocked')->nullable();
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
        Schema::dropIfExists('users');
    }
}
