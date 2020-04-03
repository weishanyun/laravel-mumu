<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class AdminUser extends Authenticatable implements JWTSubject
{
    use Notifiable,
        HasRoles;


    protected $table='admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Set password attribute
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /*
     *  implement JWTSubject method
     */

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isRoot()
    {
        return $this->name === 'admin';
    }

    public function canAccessRoute(Request $request)
    {

        $filterd =  $this->getPermissionsViaRoles()->filter(function ($permission) use($request) {
//            $method = strtoupper($request->method());
            $name =  $request->route()->getAction('as');
//            $httpMethods = array_map('strtoupper',$permission->http_method )?? [];
            $slug = $permission->slug ?? [];
//            return in_array($method,array_values($httpMethods)) && in_array($uri,array_values($httpPaths));
//            return in_array($name,array_values($httpPaths));
            return $name==$slug?true:false;
        });
        return $filterd->count();
    }
}
