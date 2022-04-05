<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class Cart extends Model
{
    use HasFactory;

    protected $table="carts";


    protected $primaryKey = "id";


    protected $fillable = ['user_id','product_id','quantity'];

    public function Product(){
        return $this->belongsTo(Product::class)->select('id','name','image','price');
    }
}
