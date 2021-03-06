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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('plan_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('stripe_id')->unique();
            $table->string('subscription_id')->nullable();
            $table->string('subscription_item_id')->nullable();
            $table->string('stripe_status');
            $table->string('stripe_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->bigInteger('trial_ends_at')->nullable();
            $table->bigInteger('ends_at')->nullable();
            $table->text('body')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'stripe_status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
