<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('order_id')->unsigned()->references('id')->on('orders');
            $table->foreignId('user_id')->unsigned()->references('id')->on('users');
            $table->double('ammount', 12, 6);
            $table->morphs('transactionable');
            $table->string('currency');
            $table->string('payment_gateway');
            $table->string('payment_gateway_id')->unique();
            $table->string('payment_gateway_uuid')->unique();
            $table->string('json_response')->nullable();
            $table->tinyInteger('status')->comment('0 for pending,1 for complited,2 for failed');
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
        Schema::dropIfExists('transactions');
    }
}
