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
        return Product::select('id','name','image')->whereIn('id', $products)->get()->makeHidden(['soldBy','CartStatus','FavouriteId','favourite']);
    }
}
