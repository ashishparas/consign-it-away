<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('vendor_id')->unsigned()->nullable();
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->bigInteger('variant_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phonecode')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('quantity')->nullable();
            $table->string('offer_price')->nullable();
            $table->text('comment')->nullable();
            $table->enum('status',[1,2,3])->default(1)->comment('1->Pending,2->Accepted,3->Rejected');
            $table->enum('isCheckout',[0,1])->default(0)->comment("0->ischeckout_true, 1->ischeckout_false");
            $table->enum('client_status',[1,2,3])->default(1)->comment('1->Pending,2->Accept,3->Reject');
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
        Schema::dropIfExists('offers');
    }
}
