<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ArticleDraftRequest;
use App\Http\Resources\Api\ArticleDraftResource;
use App\Models\ArticleDraft;
use Illuminate\Http\Request;

class ArticleDraftController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        $articleDrafts = ArticleDraft::with('user')
            ->where('deleted', 0)
            ->where('status', 1)
            ->paginate(config('eetree.limit'));
        return $this->success(ArticleDraftResource::collection($articleDrafts));
    }

    public function review(ArticleDraft $articleDraft, ArticleDraftRequest $request)
    {
        $articleDraft->update($request->validated());
        return $this->success();
    }
}
