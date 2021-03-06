<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    protected $table = 'category';

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
        return Cache::remember('category:tree', config('eetree.cache.ttl'), function () {
            $all = static::orderBy('order', 'asc')->get();
            return \App\Helpers\Tree::make($all);
        });
    }

    public static function getNavs()
    {
        $tree = static::getTree();
        return static::formatNav($tree);
    }

    public static function formatNav($category)
    {
        return $category->map(function ($item) {
            $tmp = [
                'name' => $item->name,
                'url' => route('category.list', ['category' => $item->id]),
            ];
            if ($item->has('children') && $item->children->isNotEmpty()) {
                $tmp['children'] = static::formatNav($item->children);
            }
            return $tmp;
        });
    }
}
