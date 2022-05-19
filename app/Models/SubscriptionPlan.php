<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $table = "subscription_plans";

    protected $primaryKey = "id";


    protected $fillable = ['name','monthly_price','yearly_price','content','features','status'];

}
