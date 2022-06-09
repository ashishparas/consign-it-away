<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;


    protected $table = "attributes";


    protected $primaryKey = "id";


    protected $fillable = ['product_id','name'];


    public function Option(){
        return $this->hasMany(\App\Models\AttributeOption::class,'attr_id')->with(['VariantItem']);
    }


   

    public function Attributes(){
        return $this->hasOne(\App\Models\AttributeOption::class,'attr_id');
    }

   


    

}
