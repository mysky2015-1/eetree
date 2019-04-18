<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable;
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $table = 'admins';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    //将密码进行加密
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Models\AdminRole', 'admin_role_user', 'user_id', 'role_id')->withTimestamps();
    }

    public function allPermissions()
    {
        $permissions = \Illuminate\Support\Facades\Redis::get('admin:permissions:' . $this->id);
        if (empty($permissions)) {
            $permissions = $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->map(function ($item, $key) {
                return $item->only(['name', 'http_method', 'http_path']);
            });
            \Illuminate\Support\Facades\Redis::set('admin:permissions:' . $this->id, $permissions);
        } else {
            $permissions = collect(json_decode($permissions, true));
        }
        return $permissions;
    }
}
