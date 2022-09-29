<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\Activitylog\Traits\LogsActivity;

class UserDevice extends Model
{
    use HasFactory;

    protected $table = "user_devices";
    
    
    
    protected $primaryKey = "id";
    
    
    protected $fillable = ['user_id', 'type', 'token'];
}
