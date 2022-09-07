<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class cancellation extends Model
{
    use HasFactory;

    protected $table = "cancellations";


    protected $primaryKey = "id";


    protected $appends = ['RequestCount','Image'];

    protected $fillable = ['user_id','item_id','vendor_id','product_id','reason','image','status','type'];


    public function getImageAttribute($value){
        // dd($value);
        if(isset($value)):

        return explode(',', $value);  
        endif;
    }

    public function Customer(){
        return $this->hasOne(User::class,'id','user_id')->select('id','name','fname','lname','profile_picture','phonecode','mobile_no');
    }

    public function Product(){
        return $this->belongsTo(Product::class)->select('id','user_id','category_id','store_id','name','price','discount','image')->with(['Category']);
    }

    public function getRequestCountAttribute(){
        return cancellation::where('type','2')->where('status','1')->where('vendor_id', Auth::id())->count();
    }

    public function Item(){
        return $this->hasOne(Item::class,'id','item_id');
    }

   
}
