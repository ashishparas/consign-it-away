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
            $table->string('name');
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('gender',[1,2,3])->default(1)->comment('1->Male,2->Female,3->other');
            $table->string('phonecode')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('email_otp')->nullable();
            $table->string('mobile_otp')->nullable();
            $table->enum('type',[1,2,3,4])->default(1)->comment('1->User,2->Vendor,3->Both,4->Admin')->nullable();
            $table->enum('status',[0,1,2,3])->default(0)->comment('0->Default,1->signup,2->verification or create profile, 3->Subscription or Mobile verification');
            $table->string('fax')->nullable();
            $table->string('paypal_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('amazon_id')->nullable();
            $table->string('apple_id')->nullable();
            $table->text('token')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
