<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    const ADMIN_ROLE = 1;
    const USER_ROLE = 2;
    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image'
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
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        $this->attributes['password'] = !empty($input) ? bcrypt($input) : bcrypt(env('APP_Pass'));
    }

    /**
     * get images attribute
     *
     * @return string
     */
    public function getImageAttribute()
    {
        return $this->attributes['image']
            ? Storage::url($this->attributes['image'])
            : URL::asset('images/default-user.png');
    }

    /**
     * get list roles cannot delete
     */
    public static function getRolesNotDelete()
    {
        return [static::ADMIN_ROLE, static::USER_ROLE];
    }

    /**
     * @return mixed
     *
     * @author <hieunt@evolableasia.vn>
     */
    public function checkIsAdmin()
    {
        return $this->hasRole(Role::findById(static::ADMIN_ROLE, $this->guard_name));
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        // TODO: Implement getJWTIdentifier() method.
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // TODO: Implement getJWTCustomClaims() method.
        return [];
    }
}
