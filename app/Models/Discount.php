<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Discount extends Model
{
    use HasFactory;


    protected $table ="discounts";

    protected $primaryKay = "id";

    protected $fillable= ['category_id','user_id','banner','percentage','description', 'start_date', 'valid_till','status'];

    protected $appends = ['DiscountBaseUrl'];

     public function getDiscountBaseUrlAttribute()
     {
         return url('discount/');
     }

    public function Category(){
        return $this->belongsTo(Category::class)->select('id','title');   
    }


    public function Products(){
        return $this->hasMany(Product::class,"discount","id")->where('user_id', Auth::id())->select('id','name','image','discount');
    }



}
