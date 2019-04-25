<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'admin';
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
        $permissions = false; //TODORedis::get('admin:permissions:' . $this->id);
        if (empty($permissions)) {
            $permissions = $this->roles()->with('permissions')->get()->pluck('permissions')->flatten()->unique(function ($item) {
                return $item->id;
            })->map(function ($item, $key) {
                return $item->only(['name', 'http_method', 'http_path']);
            });
            Redis::set('admin:permissions:' . $this->id, $permissions);
        } else {
            $permissions = collect(json_decode($permissions, true));
        }
        return $permissions;
    }

    /**
     * A user has and belongs to many menus.
     *
     * @return BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany('App\Models\AdminRoleMenu', 'admin_role_user', 'user_id', 'role_id', 'id', 'role_id')->withTimestamps();
    }

    public function roleMenus()
    {
        $menus = false; //TODORedis::get('admin:menus:' . $this->id);
        if (empty($menus)) {
            $menuIds = $this->menus->pluck('menu_id')->toArray();
            $allMenus = config('eetree.menus');
            $menus = $this->setMenus($allMenus, $menuIds);
            Redis::set('admin:menus:' . $this->id, json_encode($menus));
        } else {
            $menus = collect(json_decode($menus, true));
        }
        return $menus;
    }

    public function setMenus($menus, $menuIds)
    {
        foreach ($menus as $key => $value) {
            if (!isset($value['id']) || in_array($value['id'], $menuIds)) {
                if (isset($value['id'])) {
                    unset($menus[$key]['id']);
                }
                if (!empty($value['children'])) {
                    $menus[$key]['children'] = $this->setMenus($value['children'], $menuIds);
                }
            } else {
                unset($menus[$key]);
            }
        }
        return $menus;
    }
}
