<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCategory extends Model
{
    protected $fillable = [
        'parent_id', 'name', 'order',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public static function getTree()
    {
        $all = static::orderBy('order', 'asc')->get();
        return \App\Helpers\Tree::make($all);
    }
}
