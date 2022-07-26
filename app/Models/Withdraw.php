<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;



    protected $table = "withdraws";


    protected $primaryKey = "id";



    protected $fillable = ['user_id','amount','status','date'];



    public function User(){
        return $this->hasOne(User::class,'id','user_id')->select('id','name','fname','lname','profile_picture')->with(['StoreName']);
    }

}
