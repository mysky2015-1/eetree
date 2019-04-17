<?php

namespace App\Http\Resources\Api;

use Illuminate\Support\Collection;

trait Tree
{

    public static function tree($data)
    {
        return self::formatTree($data, collect([]));
    }

    public static function subTree($tree, $id)
    {
        $result = null;
        $tree->each(function ($item, $key) use ($id, $result) {
            if ($item->id == $id) {
                $result = $item->children;
                return false;
            }
        });
        return $result;
    }

    /**
     * @param \Illuminate\Support\Collection $data
     * @param \Illuminate\Support\Collection $parents
     *
     * @return \Illuminate\Support\Collection
     */
    protected static function formatTree(Collection $data, Collection $parents)
    {
        $data->map(function ($item, $key) use ($data, $parents) {
            $item->children = \collect([]);

            if (empty($item->parent_id)) {
                $parents->push($item);

                $data->forget($key);
            }

            $parents->map(function ($parentItem, $parentKey) use ($key, $item, $data, $parents) {
                if ($item->parent_id == $parentItem->id) {
                    $parents->get($parentKey)->children->push($item);

                    $data->forget($key);
                }
            });
        });

        $parents->map(function ($parentItem, $key) use ($data, $parents) {
            if ($parentItem->children->isNotEmpty()) {
                $parents->get($key)->children = self::formatTree($data, $parentItem->children);
            }
        });

        return $parents;
    }
}
