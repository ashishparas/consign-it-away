<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table="addresses";

    protected $primaryKey = "id";


    protected $fillable = ['user_id','marital_status','fname','lname','email','phonecode','mobile_no','type','address','city','state','zipcode','country','status'];
}
