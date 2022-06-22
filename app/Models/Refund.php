<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $table = "refunds";

    protected $PrimaryKey = "id";


    protected $fillable = ['order_id','cus_id','vendor_id','refund_preference','amount','ship_from','shipping_type','reason'];
}
