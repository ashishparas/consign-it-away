<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Rating;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpseclib3\Crypt\Common\Formats\Signature\Raw;

class Product extends Model
{
    use HasFactory;

    protected $table ="products";



    protected $primaryKey = "id";

    protected $fillable = [
        'user_id','category_id','subcategory_id','store_id','name','image',
        'description','price','discount','brand','color','quantity','weight',
        'condition','dimensions','available_for_sale', 'customer_contact',
        'inventory_track','product_offer','ships_from','shipping_type',
        'is_variant','free_shipping','meta_description','meta_tags',
        'meta_keywords','title','variants','state','tags','advertisement',
        'selling_fee','amount','status'    
    ];


    protected $appends = ['base_url','favourite','FavouriteId','CartStatus','soldBy'];



    public function getCartStatusAttribute(){
        $cart_status = Cart::where('product_id',$this->id)->where('user_id', Auth::id())->first();
        $cart = (!empty($cart_status))? 'added_to_cart':'not_in_cart';
        return $cart;
    }
       
    public function getSoldByAttribute(){
        $store =  Store::select('id','banner','name')->where('id', $this->store_id)->first();
        return $store;
    }


    public function getFavouriteAttribute()
    {
       $favourite = Favourite::where('product_id', $this->id)->where('by', Auth::id())->first();
       $fvrt = (!$favourite)? null:$favourite->status;
       return $fvrt; 
    }

    public function getFavouriteIdAttribute(){
  
       $favourite = Favourite::where('product_id', $this->id)
        ->where('by', Auth::id())
        ->first();
        $ft = (!$favourite)?null:$favourite->id; 
        return (string)$ft;
    }

    public function getBaseUrlAttribute(){
        return asset('/products');
    }

    public function getImagesAttribute($value){
        return explode(',', $value);
    }

    public function getImageAttribute($value){
        return explode(',', $value);
    }
    
    

    public function Category(){
        return $this->belongsTo(Category::class)->select('id','title');
    }
   
  
    public function User(){
        return $this->hasOne(User::class,'id','user_id')->select('id','name','fname','lname','email','phonecode','mobile_no','profile_picture');
    }


    public function Rating(){   
        
      return $this->hasOne(Rating::class);
      
    }


    public function Stock(){
        return $this->hasOne(Stock::class)->select('product_id','stock');
    }


  
  public function Offer(){
      return $this->hasOne(Offer::class);
  }
   
  public function PorductRating(){
      return $this->hasOne(Rating::class,'product_id', 'id')->select('product_id',DB::raw('AVG(rating) as rating, COUNT(comment) as ratingsCount'));
  }

  public function Store(){
      return $this->belongsTo(Store::class)->select('id','name','banner')->with('Manager');
  }

    
    













}


