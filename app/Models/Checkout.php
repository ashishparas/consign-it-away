<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;


    protected $table = "checkouts";


    protected $primaryKey  = "id";


    protected $fillable = ['user_id','product_id','card_id','personal_id','address_id','status'];
}
