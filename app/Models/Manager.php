<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $table = "managers";


    protected $primaryKey = "id";

    protected $fillable = ['store_id','profile_picture','name','email','phonecode','mobile_no'];
}
