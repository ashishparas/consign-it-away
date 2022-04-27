<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;


    protected $table ="discounts";

    protected $primaryKay = "id";

    protected $fillable= ['category_id','user_id','banner','percentage','description', 'start_date', 'valid_till','status'];

    protected $appends = ['DiscountBaseUrl'];

     public function getDiscountBaseUrlAttribute()
     {
         return url('discount/');
     }

    public function Category(){
        return $this->belongsTo(Category::class)->select('id','title');   
    }

}
