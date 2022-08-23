<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Helper\Helper;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    use HasFactory;

    protected $table="carts";


    protected $primaryKey = "id";


    protected $fillable = ['user_id','vendor_id','product_id','vendor_id','variant_id','quantity'];

    protected $appends = ['Attributes','ShippingFee'];
    
    
    public function getAttributesAttribute(){
        $variant = Variant::where('id',$this->variant_id)->first();
        if($variant):
            $option_id = explode(",",$variant['option_id']);
          // DB::enableQueryLog();
            return  Attribute::select('attributes.id','attributes.name', DB::raw('attribute_options.id AS option_id, attribute_options.name AS option_name'))
                ->join("attribute_options","attributes.id","attribute_options.attr_id")
                ->whereIn('attribute_options.id', $option_id)
                ->with('Attributes')
                ->get();
            endif;
       
    }
    
    public function VendorName(){
        // return $this->hasOne(User::class, 'id', 'vendor_id')->select('id','name','fname','lname');
        return $this->hasOne(Store::class, 'id', 'vendor_id')->select('id','name','banner');
    }

    
 
    public function Product(){
      
       return $this->belongsTo(Product::class)->select('id','user_id','name','image','price','discount')->with(['Offer','Discount'])->with(['PromoCode']);
      
    }


   

    public function Offer(){
        return $this->hasOne(Offer::class,'user_id','user_id')
                ->where('product_id',$this->product_id)
                ->where('status','2');
    }


    public function CustomerVariant(){
        return $this->hasOne(Variant::class,'id','variant_id');
    }

   public function getShippingFeeAttribute()
   {
        $product = Product::select('id','ships_from','weight','dimensions')->where('id', $this->product_id)->first();
        // dd($product->toArray());
            $ShippingRate = Helper::getShippingPrice( $product);
            // dd($ShippingRate);
                return $ShippingRate;
   }
   
  
}
