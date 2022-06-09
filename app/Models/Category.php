<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
