<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $table="orders";


    protected $primaryKey = "id";

    protected $fillable = ['address_id','card_id','charge_id','order_id','items','sub_total','coupon','shipping_cost','total_amount'];
}
