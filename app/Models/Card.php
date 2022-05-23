<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $table ="cards";


    protected $primaryKey = "id";



    protected $fillable = ['user_id', 'card_no','card_holder_name','expiry_month','expiry_year','status'];

   
}
