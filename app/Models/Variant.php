<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $table="variants";


    protected $primaryKey = "id";


    protected $fillable = ['product_id','attr_id','option_id','variant_item_id'];
}
