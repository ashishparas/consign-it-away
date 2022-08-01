<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";


    protected $primaryKey = "id";


    protected $fillable = ['transaction_id','card_id','vendor_id','product_id','user_id','order_id','price','status','payment_source','order_date'];


    public function OrderDetails(){
        return $this->belongsTo(Order::class,'id')->select('id','items');
    }
    public function Customer(){
        return $this->belongsTo(User::class,'user_id')->select('id','name','fname','lname','profile_picture');
    }
    
    public function Vendor(){
        return $this->belongsTo(User::class,'vendor_id')->select('id','name','fname','lname','profile_picture','mobile_no','phonecode','fax');
    }
    
    public function Product(){
        return $this->belongsTo(Product::class,'product_id')->select('id','user_id','store_id','name','price')->with(['Store']);
    }
    
    public function Item(){
        return $this->belongsTo(Item::class,'order_id')->select('id','address_id')->with(['Address']);
    }


}
