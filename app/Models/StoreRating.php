<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreRating extends Model
{
    use HasFactory;

    protected $table = "store_ratings";

    protected $primaryKey = "id";


    protected $fillable = ['user_id','store_id','product_id','rating','comment'];

    public function User(){
        return $this->hasOne(User::class, 'id','user_id')->select('id','name','fname','lname','profile_picture');
    }
}
