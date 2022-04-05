<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;


    protected $table = "subscriptions";



    protected $primaryKey = "id";


    protected $fillable = ['name', 'monthly_price','yearly_price','status'];
}