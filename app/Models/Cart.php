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


    protected $fillable = ['user_id','product_id','quantity'];

    
    public function Product(){
        return $this->belongsTo(Product::class)->select('id','user_id','name','image','price')->with('User');
    }

    

   
}
