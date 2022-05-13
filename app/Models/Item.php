<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;


    protected $table  ="items";



    protected $primarykey="id";

    protected  $fillable = ['user_id','vendor_id','product_id','address_id','order_id','price','quantity','color','size','status'];


    public function Product(){
        return $this->belongsTo(Product::class)->select('id','user_id','store_id','name','amount','image')->with('User');
    }

    public function SoldBy(){
        return $this->hasOne(User::class,'id','vendor_id')->select('id','name','fname','lname');
    }
   
}
