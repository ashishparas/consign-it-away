<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cancellation extends Model
{
    use HasFactory;

    protected $table = "cancellations";


    protected $primaryKey = "id";


    protected $fillable = ['user_id','item_id','product_id','reason','image'];
}
