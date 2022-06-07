<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RecentProducts extends Model
{
    use HasFactory;


protected $table = "recent_products";



protected $primaryKey = "id";


protected $fillable = ['user_id','product_id','updated_at'];


protected $appends = ['FavouriteId'];

public function Product(){
    return $this->belongsTo(Product::class)->select('id','name','image','price','brand');
}

public function getFavouriteIdAttribute(){
  
    $favourite = Favourite::where('product_id', $this->id)
     ->where('by', Auth::id())
     ->first();
     $ft = (!$favourite)?null:$favourite->id; 
     return (string)$ft;
 }


}
