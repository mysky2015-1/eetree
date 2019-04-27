<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class Tree
{
    public static function make($source, $parentId = 0)
    {
        if (empty($source) || $source->isEmpty()) {
            return null;
        }
        $map = collect([]);
        $source->each(function ($item, $key) use ($map) {
            $k = 'map_' . $item->parent_id;
            if (!$map->has($k)) {
                $map->put($k, collect([]));
            }
            $map->get($k)->push($item);
        });
        return static::makeTree($map, $parentId);
    }

    public static function children($tree, $id)
    {
        if (empty($tree) || $tree->isEmpty()) {
            return null;
        }
        $result = null;
        $tree->each(function ($item, $key) use ($id, &$result) {
            if ($item->id == $id) {
                if ($item->children && $item->children->isNotEmpty()) {
                    $result = $item->children;
                }
                return false;
            } elseif ($item->children && $item->children->isNotEmpty()) {
                $find = static::children($item->children, $id);
                if ($find) {
                    $result = $find;
                    return false;
                }
            }
        });
        return $result;
    }

    public static function siblings($tree, $node)
    {
        if (empty($tree) || $tree->isEmpty()) {
            return null;
        }
        $result = collect([]);
        $tree->each(function ($item, $key) use ($node, &$result) {
            if ($node->parent_id == $item->parent_id) {
                if ($node->id != $item->id) {
                    $result->push($item);
                }
            } elseif ($item->id == $node->parent_id) {
                if ($item->children && $item->children->isNotEmpty()) {
                    $removeKey = $item->children->search(function ($sValue, $sKey) use ($node) {
                        return $sValue->id == $node->id;
                    });
                    $item->children->forget($removeKey);
                    $result = $item->children->values();
                }
                return false;
            } elseif ($item->children && $item->children->isNotEmpty()) {
                $find = static::siblings($item->children, $node->parent_id);
                if ($find) {
                    $result = $find;
                    return false;
                }
            }
        });
        return $result;
    }

    public static function ids($tree, $recursive = true)
    {
        if (empty($tree) || $tree->isEmpty()) {
            return [];
        }
        $result = [];
        $tree->each(function ($item, $key) use ($recursive, &$result) {
            $result[] = $item->id;
            if ($recursive && $item->children && $item->children->isNotEmpty()) {
                $find = static::ids($item->children, $recursive);
                $result = array_merge($result, $find);
            }
        });
        return $result;
    }

    protected static function makeTree(Collection $map, $parentId = 0)
    {
        $k = 'map_' . $parentId;
        if ($map->has($k)) {
            $tree = $map->get($k);
            $tree->transform(function ($item, $key) use ($map) {
                if ($children = static::makeTree($map, $item->id)) {
                    $item->children = $children;
                }
                return $item;
            });
        } else {
            $tree = null;
        }
        return $tree;
    }
}
