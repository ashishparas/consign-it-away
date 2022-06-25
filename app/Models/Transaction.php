<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = "transactions";


    protected $primaryKey = "id";


    protected $fillable = ['transaction_id','card_id','vendor_id','product_id','user_id','order_id','price','status','order_date'];


    public function OrderDetails(){
        return $this->hasMany(Item::class,'id','order_id')->select('id','status');
    }
    public function Customer(){
        return $this->belongsTo(User::class,'user_id')->select('id','name','fname','lname','profile_picture');
    }
    public function Vendor(){
        return $this->belongsTo(User::class,'vendor_id')->select('id','name','fname','lname','profile_picture');
    }


    


}
