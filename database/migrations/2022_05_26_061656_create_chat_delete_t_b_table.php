<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatDeleteTBTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_deleteTB', function (Blueprint $table) {
            $table->increments('ID');
            $table->bigInteger('deleteByuserID')->nullable();
            $table->bigInteger('ChatParticipantID')->nullable();
            $table->timestamp('deletedDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_deleteTB');
    }
}
