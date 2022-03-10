<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table ="banks";


    protected $primaryKey ="id";


    protected $fillable = ['user_id','bank_ac_no','routing_no'];
}
