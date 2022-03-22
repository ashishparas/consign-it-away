<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table ="products";



    protected $primaryKey = "id";


    protected $appends = ['base_url'];

    protected $fillable = [
        'user_id',
        'category_id',
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




    public function getBaseUrlAttribute(){
        return public_path('/products');
    }

    public function Rating(){
        return $this->hasOne(Rating::class);
    }
    public function Category(){
        return $this->belongsTo(Category::class)->select('id','title');
    }
   

    













}


