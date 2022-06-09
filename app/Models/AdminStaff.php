<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminStaff extends Model
{
    use HasFactory;

    protected $table = "admin_staff";

    protected $primaryKay = "id";

    protected $fillable = ['user_id','image','name','email','phonecode','mobile_no','role'];
}
