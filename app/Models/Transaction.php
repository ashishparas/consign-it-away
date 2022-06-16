<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";


    protected $primaryKey = "id";


    protected $fillable = ['transaction_id','vendor_id','product_id','user_id','order_id','price','order_date'];


    public function OrderDetails(){
        return $this->hasMany(Item::class,'order_id','order_id')->select('order_id','status');
    }


}