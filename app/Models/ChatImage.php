<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatImage extends Model
{
    use HasFactory;


    protected $table ="chat_images";


    protected $primaryKey = "id";


    protected $fillable = ['user_id','image'];

    protected $appends = ['base_url'];

    public function getBaseUrlAttribute(){
        return asset('chatImage/'.$this->image); 
    }
}
