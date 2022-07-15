<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Offer extends Model
{
    use HasFactory;

    protected $table = "offers";


    protected $primaryKey = "id";


    protected $fillable = ['user_id','vendor_id','product_id','variant_id','name','email','phonecode','mobile_no','quantity','offer_price','comment','status','isCheckout','client_status'];



    public function Product(){
        return $this->belongsTo(Product::class)->select('id','name','image',DB::raw('price as amount'),'discount')->with(['Discount']);
    }

    public function Variants(){
        return $this->hasOne(Variant::class)->select('id','price');
    }
}
