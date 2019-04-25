<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    protected $table = 'admin_role';

    protected $fillable = [
        'name',
    ];

    /**
     * A role belongs to many users.
     *
     * @return BelongsToMany
     */
    public function admins()
    {
        return $this->belongsToMany('App\Models\Admin', 'admin_role_user', 'role_id', 'user_id');
    }

    /**
     * A role belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Models\AdminPermission', 'admin_role_permission', 'role_id', 'permission_id')->withTimestamps();
    }

    /**
     * A role has many menus.
     *
     * @return hasMany
     */
    public function menus()
    {
        return $this->hasMany('App\Models\AdminRoleMenu', 'role_id');
    }
}
