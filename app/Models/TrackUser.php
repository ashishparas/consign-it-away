<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackUser extends Model
{
    use HasFactory;


    protected $table = "track_users";


    protected $PrimaryKey ="id";

    protected $fillable = ['id', 'ip'];
}
