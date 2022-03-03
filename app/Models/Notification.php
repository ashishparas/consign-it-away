<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'body', 'data', 'created_by','receiver_id', 'is_read'];

    /**
     * Change activity log event description
     *
     * @param string $eventName
     *
     * @return string
     */
    
    public function getDataAttribute($value) {
       
        return $value = Null ? [] : json_decode($value);
    }
    
    public function getDescriptionForEvent($eventName) {
        return __CLASS__ . " model has been {$eventName}";
    }
}
