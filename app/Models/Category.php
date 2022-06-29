<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use HasFactory;

    protected $table="categories";
    
    
    protected $fillable = ['title','image', 'type'];

    protected $primaryKey = "id";

    protected $appends = ['CategoryBaseUrl'];

    public function getCategoryBaseUrlAttribute(){
        return url('category');
    }


    public function Subcategories(){
        return $this->hasMany(Subcategory::class);
    }

    public function Products(){
        return $this->hasMany(Product::class,"category_id")->select('id','category_id','name','image')->where('user_id',Auth::id());
    }

   

}
