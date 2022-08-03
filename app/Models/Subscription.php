<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubscriptionPlan;

class Subscription extends Model
{
    use HasFactory;


    protected $table = "subscriptions";


    protected $fillable = ['user_id','plan_id','subscription_id','subscription_item_id','name','type','stripe_id','stripe_status','stripe_price','quantity','trial_ends_at','ends_at','body'];

    protected $primaryKey = "id";
    
    public function SubscriptionPlan(){
      return $this->hasOne(SubscriptionPlan::class,'id', 'plan_id')->select('id','name','content','monthly_price','yearly_price');
    }


}
