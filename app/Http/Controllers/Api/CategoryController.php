<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Tree;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use App\Models\Doc;
use DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        $categories = Category::orderBy('order', 'asc')->get();
        // $categories = Tree::make($categories);
        return $this->success(CategoryResource::collection($categories));
    }

    //删除菜单
    public function delete(Category $category)
    {
        $all = Category::getTree();
        $subTree = Tree::children($all, $category->id);
        $deleteIds = Tree::ids($subTree);
        $deleteIds[] = $category->id;
        DB::transaction(function () use ($category, $deleteIds) {
            Category::whereIn('id', $deleteIds)->delete();
            Category::where('parent_id', $category->parent_id)
                ->where('order', '>', $category->order)
                ->decrement('order');
            Doc::whereIn('category_id', $deleteIds)->update(['category_id' => 0]);
        });

        return $this->success();
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['order'] = Category::where('parent_id', $data['parent_id'])->count();
        $category = Category::create($data);
        return $this->success(new CategoryResource($category));
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $data = $request->validated();
        $category->update($data);
        return $this->success();
    }

    public function move(Category $category, Request $request)
    {
        $destId = $request->input('dest');
        $destCategory = Category::find($destId);
        $type = $request->input('type');
        if ($category->id === $destCategory->id) {
            return $this->failed('参数有误');
        }
        DB::transaction(function () use ($category, $destCategory, $type) {
            Category::where('parent_id', $category->parent_id)
                ->where('order', '>', $category->order)
                ->decrement('order');
            if ($type === 'before') {
                $category->update(['parent_id' => $destCategory->parent_id, 'order' => $destCategory->order]);
                Category::where('parent_id', $destCategory->parent_id)
                    ->where('id', '<>', $category->id)
                    ->where('order', '>=', $destCategory->order)
                    ->increment('order');
            } elseif ($type === 'after') {
                $category->update(['parent_id' => $destCategory->parent_id, 'order' => $destCategory->order + 1]);
                Category::where('parent_id', $destCategory->parent_id)
                    ->where('id', '<>', $category->id)
                    ->where('order', '>', $destCategory->order)
                    ->increment('order');
            } else {
                // inner
                $order = Category::where('parent_id', $destCategory->id)->count();
                $category->update(['parent_id' => $destCategory->id, 'order' => $order]);
            }
        });

        return $this->success();
    }
}
