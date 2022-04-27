<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;


    protected $table  ="items";



    protected $primarykey="id";

    protected  $fillable = ['user_id','product_id','order_id','price','color','size','status'];


    public function Product(){
        return $this->belongsTo(Product::class)->select('id','user_id','name','amount','image')->with('User');
    }
}
