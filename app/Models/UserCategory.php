<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCategory extends Model
{
    use SoftDeletes;

    protected $table = 'user_category';

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

    public static function getTree($userId)
    {
        $all = static::where('user_id', $userId)->orderBy('order', 'asc')->get();
        return \App\Helpers\Tree::make($all);
    }
}
