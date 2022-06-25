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
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('card_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->bigInteger('vendor_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('order_id')->nullable();
            $table->string('price')->nullable();
            $table->enum('status',[1,2,3])->default(1)->comment('1-> credit,2->debit, 3->pending');
            $table->string('order_date')->nullable();
            
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
        Schema::dropIfExists('transactions');
    }
}
