<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('cus_id')->unsigned()->nullable();
            $table->foreign('cus_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('vendor_id')->nullable();
            $table->string('refund_preference')->nullable();
            $table->string('amount')->nullable();
            $table->string('ship_from')->nullable();
            $table->string('shipping_type')->nullable();
            $table->text('reason')->nullable();
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
        Schema::dropIfExists('refunds');
    }
}
