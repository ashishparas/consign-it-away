<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
// use Laravel\Passport\HasApiTokens;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'fname',
        'lname',
        'email',
        'password',
        'marital_status',
        'phonecode',
        'mobile_no',
        'type',
        'email_otp',
        'mobile_otp',
        'profile_picture',
        'status',
        'is_switch',
        'switch_status',
        'fax',
        'paypal_id',
        'paypal_id_status',
        'bank_ac_no',
        'routing_no',
        'street_address',
        'city',
        'state',
        'country',
        'zipcode',
        'apple_id',
        'facebook_id',
        'google_id',
        'amazon_id',
        'token',
        'cus_id',
        'mobile_no_found'
    ];


    protected $appends = ['base_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getBaseUrlAttribute(){
        return url('vendor');
    }


    public function AauthAcessToken(){
        return $this->hasMany('\App\Models\OauthAccessToken');
    }

    public static function usersIdByPermissionName($name) {

        $permissions = \App\Models\Permission::where('name', 'like', '%' . $name . '%')->get();
        if ($permissions->isEmpty())
            return [];
        $role = DB::table('permission_role')->where('permission_id', $permissions->first()->id)->get();
        if ($role->isEmpty())
            return [];
        return DB::table('role_user')->whereIN('role_id', $role->pluck('role_id'))->pluck('user_id')->toArray();
    }


}
