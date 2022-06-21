<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\User;
class Cart extends Model
{
    use HasFactory;

    protected $table="carts";


    protected $primaryKey = "id";


    protected $fillable = ['user_id','vendor_id','product_id','vendor_id','quantity'];

    
    public function VendorName(){
        // return $this->hasOne(User::class, 'id', 'vendor_id')->select('id','name','fname','lname');
        return $this->hasOne(Store::class, 'id', 'vendor_id')->select('id','name','banner');
    }

    
 
    public function Product(){
        return $this->belongsTo(Product::class)->select('id','user_id','name','image','price')->with(['Offer']);
    }

    public function Offer(){
        return $this->hasOne(Offer::class,'user_id','user_id')
                ->where('product_id',$this->product_id)
                ->where('status','2');
    }

   
  
}
