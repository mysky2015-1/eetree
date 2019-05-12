<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Helpers\Tree;
use App\Http\Requests\Api\UserCategoryRequest;
use App\Http\Resources\DocDraftResource;
use App\Http\Resources\UserCategoryResource;
use App\Models\DocDraft;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCategoryController extends Controller
{
    use ApiResponse;

    public function folder(Request $request)
    {
        $parentId = (int) $request->input('id');
        $userId = Auth::id();

        $categories = UserCategory::where([
            ['user_id', $userId],
            ['parent_id', $parentId],
        ])->orderBy('order', 'asc')->get();

        $docs = DocDraft::where([
            ['user_id', $userId],
            ['user_category_id', $parentId],
            ['title', '<>', ''],
        ])->get();

        return $this->success([
            'categories' => UserCategoryResource::collection($categories),
            'docs' => DocDraftResource::collection($docs),
        ]);
    }

    public function store(UserCategoryRequest $request)
    {
        $userId = Auth::id();
        $data = $request->validated();
        $count = UserCategory::where('user_id', $userId)->count();
        if ($count >= config('eetree.usercategory.max')) {
            return $this->failed('文件夹个数超出限制');
        }
        $data['order'] = UserCategory::where([
            ['user_id', $userId],
            ['parent_id', $data['parent_id']],
        ])->count();
        $fileCount = DocDraft::where([
            ['user_id', $userId],
            ['user_category_id', $data['parent_id']],
        ])->count();
        if ($data['order'] + $fileCount >= config('eetree.usercategory.maxNode')) {
            return $this->failed('当前文件夹下文件数超出限制');
        }
        $category = new UserCategory;
        $category->fill($data);
        $category->user_id = $userId;
        $category->save();
        return $this->success(new UserCategoryResource($category));
    }

    public function update(UserCategory $category, UserCategoryRequest $request)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }
        $data = $request->validated();
        $category->update($data);
        return $this->success();
    }

    public function delete(UserCategory $category)
    {
        $userId = Auth::id();
        $all = UserCategory::getTree($userId);
        $subTree = Tree::children($all, $category->id);
        $deleteIds = Tree::ids($subTree);
        $deleteIds[] = $category->id;
        \DB::transaction(function () use ($category, $deleteIds) {
            UserCategory::whereIn('id', $deleteIds)->delete();
            UserCategory::where('parent_id', $category->parent_id)
                ->where('order', '>', $category->order)
                ->decrement('order');
        });

        return $this->success();
    }

    public function move(UserCategory $category, Request $request)
    {
        $userId = Auth::id();
        $destId = $request->input('dest');
        $destCategory = UserCategory::find($destId);
        if ($category->id === $destCategory->id ||
            $category->user_id !== $userId ||
            $destCategory->id !== $userId) {
            return $this->failed('参数有误');
        }
        DB::transaction(function () use ($category, $destCategory) {
            UserCategory::where('parent_id', $category->parent_id)
                ->where('order', '>', $category->order)
                ->decrement('order');
            // inner
            $order = UserCategory::where([
                ['user_id', $userId],
                ['parent_id', $destCategory->id],
            ])->count();
            $category->update(['parent_id' => $destCategory->id, 'order' => $order]);
        });

        return $this->success();
    }
}
