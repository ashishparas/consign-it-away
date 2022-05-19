<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = "offers";


    protected $primaryKey = "id";


    protected $fillable = ['user_id','product_id','name','email','phonecode','mobile_no','quantity','offer_price','comment','status'];
}
