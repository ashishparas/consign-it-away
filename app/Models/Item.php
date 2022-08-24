<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helper\Helper;
class Item extends Model
{
    use HasFactory;


    protected $table  ="items";



    protected $primarykey="id";

    protected  $fillable = ['user_id','tracking_id','vendor_id','product_id','variant_id','offer_id','address_id','order_id','price','quantity','color','size','status'];

    protected $appends = ['selectedVariants','tracking_status'];


    public function getTrackingStatusAttribute(){
        
        if($this->tracking_id):
            
            $tracking = Helper::trackCourier($this->tracking_id);
            return ($tracking['data'])? $tracking['data']:null;
        endif;
        return '';
        
    }

    public function getSelectedVariantsAttribute()
    {
        return Helper::ProductvariantById($this->variant_id);
    }
    public function Product(){
        return $this->belongsTo(Product::class)->select('id','user_id','store_id','name','price','discount','image','description','category_id','weight', 'variants','tags','meta_description','selling_fee','shipping_type')->with(['User','Category','Discount']);
    }

    public function SoldBy(){
        return $this->hasOne(User::class,'id','vendor_id')->select('id','name','fname','lname');
    }
   

    public function Rating(){
        return $this->hasOne(Rating::class,'product_id','product_id')->select('id','product_id',DB::raw('AVG(rating) as rating, COUNT(comment) as RatingCount'));
    }

    public function MyRating(){
        return $this->hasOne(Rating::class,'product_id','product_id')->where('from', Auth::id());
    }

    public function Customer(){
        return $this->hasOne(User::class,'id','user_id')->select('id','name','fname','lname','profile_picture','phonecode','mobile_no');
    }

    public function Address(){
        return $this->hasOne(Address::class,'id','address_id');
    }

    public function Transaction(){
        return $this->hasOne(Transaction::class,'order_id','order_id');
    }
    
    
    public function ProductVariants(){
        return \App\Models\Attribute::where('product_id',$this->product_id)->with(['AttributeOption'])->get();
    }

    public function cancelRequest(){
        return $this->hasOne(cancellation::class);
    }

    public function Offer(){
        return $this->hasOne(Offer::class,'id','offer_id');
    }

    public function CustomerVariant(){
        return $this->hasOne(Variant::class,'id','variant_id');
    }



}
