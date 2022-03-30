<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $table = "personals";


    protected $primaryKey = "id";


    protected $fillable = ['user_id','product_id','mertial_status','fname','lname','email','phonecode','mobile_no','status'];
    
}
