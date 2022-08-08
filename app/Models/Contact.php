<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = "contacts";


    protected $primaryKey = "id";

    protected $fillable = ['user_id','image','name','email','phonecode','mobile_no','order_no','comment'];

    protected $appends = ['baseUrl'];



    public function getBaseUrlAttribute(){
        return asset('public/vendor');
    }
    
 
}
