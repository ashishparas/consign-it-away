<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_staff', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phonecode')->nullable();
            $table->string('mobile_no')->nullable();
            $table->enum('role',[0,1,2,3,4,5,6,7,8])->default(0)->comment('0->Default,1->OrderMgt,2->VendorMgt,3->SubscriptionMgt,4->productMgt,5->TransactionMgt,6->StaffMgt,7->ReturnAndRefund,8->ReportMgt');
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
        Schema::dropIfExists('admin_staff');
    }
}
