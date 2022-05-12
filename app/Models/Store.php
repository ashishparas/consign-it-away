<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $table = "stores";


    protected $primaryKey = "id";


    protected $fillable = ['banner','user_id','store_image','name','location','description','photos'];



    public function staff(){
        return $this->hasMany(Manager::class);
    }

}
