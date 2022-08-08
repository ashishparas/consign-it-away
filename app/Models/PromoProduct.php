<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromoProduct extends Model
{
    use HasFactory;


    protected $table = "promo_products";

    protected $primaryKey = "id";

    protected $fillable = ['user_id','code_id','product_id','expiry_date','status'];



    public function CodeName(){
        return $this->hasOne(PromoCode::class,'id','code_id');
    }






}

