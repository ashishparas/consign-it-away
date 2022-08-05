<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    use HasFactory;

    protected $table = "promo_codes";



    protected $primarykey = "id";


    protected $fillable = ['user_id','product_id','name','amount','expiry','status'];


    protected $appends = ['Product']; 

 
    public function getProductAttribute(){
        $products = explode(',',$this->product_id);
        return Product::
        select('products.id','products.name','products.image','products.price','products.category_id','categories.title')
        ->Join('categories','products.category_id','categories.id')
        ->whereIn('products.id', $products)
        ->get()
        ->makeHidden(['soldBy','CartStatus','FavouriteId','favourite']);
    }





    
}
