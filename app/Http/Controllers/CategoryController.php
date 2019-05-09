<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\Api\UserCategoryRequest;
use App\Http\Resources\DocDraftResource;
use App\Http\Resources\UserCategoryResource;
use App\Models\Category;
use App\Models\Doc;
use App\Models\DocDraft;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index(Category $category, Request $request)
    {
        $params = $request->all();
        $params['category_id'] = $category->id;
        $docs = Doc::search($params);

        return view('doc/index', [
            'docs' => $docs,
        ]);
    }

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
