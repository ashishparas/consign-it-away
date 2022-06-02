<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
class Store extends Model
{
    use HasFactory;

    protected $table = "stores";


    protected $primaryKey = "id";


    protected $fillable = ['banner','user_id','store_image','name','location','description','photos'];

    protected $appends = ['base_url'];

    public function getBaseUrlAttribute(){
        return asset('vendor');
    }

    public function staff(){
        return $this->hasMany(Manager::class);
    }

    public function Product(){
        return $this->hasMany(Product::class)->select('id','store_id','name','image','amount');
    }

}
