<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Rating extends Model
{
    use HasFactory;

    protected $table = "ratings";

    protected $primaryKey = "id";


    protected $fillable = ['product_id','to','from','rating','upload','comment'];

    protected $appends = ['Upload'];

    public function getUploadAttribute($value)
    {
        return explode(',', $value);
    }
   
    public function User(){
        return $this->hasOne(User::class,'id','from')->select('id','name','fname','lname','profile_picture');
    }

    

  

}
