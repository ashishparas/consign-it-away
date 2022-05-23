<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $table="variants";


    protected $primaryKey = "id";


    protected $fillable = ['product_id','attr_id','option_id','variant_item_id','price','quantity'];


    public function Attributes(){
        return $this->hasOne(Attribute::class,'id','attr_id')->select('id','name')->with(['AttrOption']);
    }

  

    public function variantPrice(){
        return $this->hasOne(VariantItems::class,'id', 'variant_item_id')->select('id','price','quantity');
    }
   
}
