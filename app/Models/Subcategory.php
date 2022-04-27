<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $table = "subcategories";


    protected $primaryKey = "id";


    protected $fillable = ['category_id','title','image'];


    public function Category(){
        return $this->belongsTo(Category::class)->select('id','title');
    }

}
