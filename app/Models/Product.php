<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Rating;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table ="products";



    protected $primaryKey = "id";


    

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'name',
        'image',
        'description',
        'price',
        'discount',
        'brand',
        'color',
        'quantity',
        'weight',
        'condition',
        'dimensions',
        'available_for_sale',
        'customer_contact',
        'inventory_track',
        'product_offer',
        'ships_from',
        'shipping_type',
        'free_shipping',
        'meta_description',
        'meta_tags',
        'meta_keywords',
        'title',
        'variants',
        'state',
        'tags',
        'advertisement',
        'selling_fee',
        'amount'
    ];


    protected $appends = ['base_url','rating','ReviewCount'];


    public function getReviewCountAttribute(){
        return Rating::where('product_id', $this->id)->count();
    }
    
    public function getRatingAttribute(){
         $Rating = number_format(Rating::where('product_id', $this->id)->avg('rating'),1);
        return $Rating;
    }

    public function getVariantsAttribute($value)
    {
    return json_decode($value);
    }


    public function getBaseUrlAttribute(){
        return public_path('/products');
    }

    public function getImageAttribute($value){
        return explode(',', $value);
    }

    
    

    public function Category(){
        return $this->belongsTo(Category::class)->select('id','title');
    }
   
  
    public function User(){
        return $this->hasOne(User::class,'id','user_id')->select('id','fname','lname');
    }

    













}


