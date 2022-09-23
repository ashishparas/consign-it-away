<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
class Store extends Model
{
    use HasFactory;

    protected $table = "stores";


    protected $primaryKey = "id";


    protected $fillable = ['banner','user_id','store_image','name','location','address','city','state','country','zipcode','description','photos','status','store_privacy'];
    protected $appends = ['base_url'];



    public function getPhotosAttribute($value){
        return explode(",", $value);
    }



    public function getBaseUrlAttribute(){
        return asset('vendor');
    }

    public function staff(){
        return $this->hasMany(Manager::class);
    }

    public function Manager(){
        return $this->hasOne(Manager::class)->where('status','2');
    }

    public function Product(){
        return $this->hasMany(Product::class)->select('id','store_id','name','image','amount','quantity')->with(['PorductRating']);
    }
    
    public function PorductRating(){
      return $this->hasOne(Rating::class,'product_id', 'id')->select('product_id',DB::raw('AVG(rating) as rating, COUNT(comment) as ratingsCount'));
    }
    
    public function Vendor(){
        return $this->belongsTo(User::class,'user_id')->select('id','name','fname','lname','profile_picture','mobile_no','phonecode','fax','bank_ac_no','routing_no')->with(['Bank']);
    }
    
    public function Subscription(){
      return $this->hasMany(Subscription::class,'user_id', 'user_id')->select('plan_id','user_id','type','stripe_status','created_at')->with(['SubscriptionPlan']);
    }
    
    public function Bank(){
        return $this->belongsTo(Bank::class,'user_id')->select('id','user_id','name','bank_ac_no','routing_no');
    }


    public function StoreRatings(){
        return $this->hasMany(StoreRating::class,'store_id', 'id')->with(['User'])->orderBy('id', 'DESC')->take(4);
    }
    public function StoreReview(){
        return $this->hasMany(StoreRating::class,'store_id')->with(['User'])->orderBy('id', 'DESC');
    }
 

}
