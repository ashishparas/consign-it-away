<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantItems extends Model
{
    use HasFactory;

    protected $table = "variant_items";

    protected $primaryKey = "id";


    protected $fillable = ['product_id','quantity', 'price'];


    // public function variants(){
    //     return $this->hasMany(Variant::class,"variant_item_id")->select('id','product_id','variant_item_id','option_id')->with(['Attributes']);
    // }

    public function variants(){
        return $this->hasMany(Variant::class,"variant_item_id")->select('id','product_id','variant_item_id','option_id','attr_id')->with(['Attributes']);
    }
}
