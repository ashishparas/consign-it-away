<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $table = "managers";


    protected $primaryKey = "id";

    protected $appends = ['base_url'];

    protected $fillable = ['store_id','user_id','profile_picture','name','email','phonecode','mobile_no','status'];


    public function getBaseUrlAttribute(){
        return public_path('vendor');
    }





}
