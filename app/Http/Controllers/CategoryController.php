<?php

namespace App\Http\Controllers;

use App\Api\Helpers\ApiResponse;
use App\Http\Requests\Api\UserCategoryRequest;
use App\Models\DocDraft;
use App\Models\UserCategory;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use ApiResponse;

    public function folder(int $parentId = 0)
    {
        $userId = Auth::id();

        $categories = UserCategory::where([
            ['user_id', $userId],
            ['parent_id', $parentId],
        ])->orderBy('order', 'asc')->get();

        $docs = DocDraft::where([
            ['user_id', $userId],
            ['user_category_id', $parentId],
        ])->get();

        return $this->success([
            'categories' => $categories,
            'docs' => $docs,
        ]);
    }

    public function store(UserCategoryRequest $request)
    {
        $data = $request->validated();
        $data['order'] = UserCategory::where('parent_id', $data['parent_id'])->count();
        $category = UserCategory::create($data);
        return $this->success([
            'id' => $category->id,
        ]);
    }

    public function update(UserCategory $category, UserCategoryRequest $request)
    {
        $data = $request->validated();
        $category->update($data);
        return $this->success();
    }
}
