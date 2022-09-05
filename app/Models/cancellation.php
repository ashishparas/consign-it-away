<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cancellation extends Model
{
    use HasFactory;

    protected $table = "cancellations";


    protected $primaryKey = "id";


    protected $fillable = ['user_id','item_id','vendor_id','product_id','reason','image','status','type'];




    public function Customer(){
        return $this->hasOne(User::class,'id','user_id')->select('id','name','fname','lname','profile_picture','phonecode','mobile_no');
    }

    public function Product(){
        return $this->belongsTo(Product::class)->select('id','user_id','store_id','name','price','discount','image');
    }
}
