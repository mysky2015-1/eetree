<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Tree;
use App\Http\Requests\Api\CategoryRequest;
use App\Http\Resources\Api\CategoryResource;
use App\Models\Category;
use DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        $categories = Category::orderBy('order', 'asc')->get();
        $categories = Tree::make($categories);
        return $this->success(CategoryResource::collection($categories));
    }

    //删除菜单
    public function delete(Category $category)
    {
        $all = Category::orderBy('order', 'asc')->get();
        $all = Tree::make($all);
        $subTree = Tree::children($all, $category->id);
        $deleteIds = Tree::ids($subTree);
        $siblings = Tree::siblings($all, $category);
        $deleteIds[] = $category->id;
        DB::transaction(function () use ($siblings, $deleteIds) {
            //TODO update batch
            $siblings->each(function ($item, $key) {
                if ($item->order != $key) {
                    Category::where('id', $item->id)->update(['order' => $key]);
                }
            });
            //TODO deleteIds 关联表更新或删除
            Category::whereIn('id', $deleteIds)->delete();
        });

        return $this->success();
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();
        $data['order'] = Category::where('parent_id', $data['parent_id'])->count();
        Category::create($data);
        return $this->created();
    }

    public function update(Category $category, CategoryRequest $request)
    {
        $data = $request->all();
        $category->update($data);
        return $this->success();
    }
}
