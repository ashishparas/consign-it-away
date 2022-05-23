<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserChatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_chat', function (Blueprint $table) {
            $table->id();
            $table->string('roomID')->nullable();
            $table->bigInteger('source_user_id')->nullable();
            $table->bigInteger('target_user_id')->nullable();
            $table->text('message')->nullable();
            $table->string('MessageType')->nullable();
            $table->enum('status',[0,1])->default(0)->comment('0->Unread, 1->Read');
            $table->timestamp('modified_on')->useCurrent=true;
            $table->timestamp('created_on')->useCurrent=true;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_chat');
    }
}
