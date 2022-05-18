<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('subcategory_id')->nullable();
            $table->bigInteger('store_id')->nullable();
            $table->bigInteger('clear')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->string('brand')->nullable();
            $table->string('color')->nullable();
            $table->string('quantity')->nullable();
            $table->string('weight')->nullable();
            $table->string('condition')->nullable();
            $table->string('dimensions')->nullable();
            $table->enum('available_for_sale',[1,2])->default(2)->comment('1->Yes,2->No');
            $table->enum('customer_contact',[1,2])->default(2)->comment('1->Yes,2->No');
            $table->enum('inventory_track', [1,2])->default(2)->comment('1->Yes,2->No');
            $table->enum('product_offer', [1,2])->default(2)->comment('1->show,2->hide');
            $table->string('ships_from')->nullable();
            $table->string('shipping_type')->nullable();
            $table->enum('is_variant',[1,2])->default(2)->comment('2-> Yes, 1->No');
            $table->enum('free_shipping',[0,1,2])->default(0)->comment('0->Default,1->Free Shipping,2->No free shipping');
            $table->text('meta_description')->nullable();
            $table->text('meta_tags')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('title')->nullable();
            $table->text('variants')->nullable();
            $table->text('state')->nullable();
            $table->text('tags')->nullable();
            $table->enum('advertisement', [1,2])->default(2)->comment('1->Yes,2->No');
            $table->string('selling_fee')->nullable();
            $table->string('amount')->nullable();
            $table->enum('status',[1,2])->default(2)->comment('1->Product Lised, 2->Not Listed Yes');
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
        Schema::dropIfExists('products');
    }
}
