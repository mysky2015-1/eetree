<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRoleMenu extends Model
{
    protected $table = 'admin_role_menu';

    protected $fillable = [
        'menu_id', 'role_id',
    ];
}
