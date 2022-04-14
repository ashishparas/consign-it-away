<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentProducts extends Model
{
    use HasFactory;


protected $table = "recent_products";



protected $primaryKey = "id";


protected $fillable = ['user_id','product_id','updated_at'];



public function Product(){
    return $this->belongsTo(Product::class)->select('id','name','image','amount');
}



}
