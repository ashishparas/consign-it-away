<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatRoomTbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ChatRoomTb', function (Blueprint $table) {
            $table->id();
            $table->string('roomID')->nullable();
            $table->bigInteger('UserJoinID')->nullable();
            $table->integer('status')->nullable();
            $table->timestamp('createdDate')->nullable();
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
        Schema::dropIfExists('ChatRoomTb');
    }
}
