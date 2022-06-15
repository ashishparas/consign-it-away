<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Favourite extends Model
{
    use HasFactory;

    protected $table = "favourites";

    protected $primaryKey = "id";


    protected $fillable = ['product_id','by','to','status'];


    public function Product(){
        return $this->belongsTo(Product::class)->select('id','name','image', DB::raw('price as amount'));
    }
}
