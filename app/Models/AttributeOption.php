<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeOption extends Model
{
    use HasFactory;

    protected $table = "attribute_options";


    protected $primarykey = "id";


    protected $fillable = ['attr_id', 'name'];

    public function VariantItem(){
        return $this->hasOne(Variant::class,'option_id','id')->select('id','option_id','variant_item_id');
    }




}
