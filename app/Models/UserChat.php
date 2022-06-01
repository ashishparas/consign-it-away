<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    use HasFactory;

    protected $table = "user_chat";


    protected $primaryKey = "id";


    protected $fillable = ['roomID','source_user_id','target_user_id','message','MessageType','status','modified_on','created_on'];

    // protected $appends = ['Offer'];

    // public function getOfferAttribute(){
    //     return Offer::where('id', intval($this->message))->first();
    // }
}
