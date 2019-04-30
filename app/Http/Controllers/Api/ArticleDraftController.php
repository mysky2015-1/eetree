<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ArticleDraftRequest;
use App\Http\Resources\Api\ArticleDraftResource;
use App\Models\Article;
use App\Models\ArticleDraft;

class ArticleDraftController extends Controller
{
    //返回菜单列表
    public function index(ArticleDraftRequest $request)
    {
        $articleDrafts = ArticleDraft::with('user')
            ->where('status', $request->input('status'))
            ->paginate(config('eetree.limit'));
        return $this->success(ArticleDraftResource::collection($articleDrafts));
    }

    public function review(ArticleDraft $articleDraft, ArticleDraftRequest $request)
    {
        if ($articleDraft->status !== ArticleDraft::STATUS_SUBMIT) {
            return $this->failed('参数有误');
        }
        \DB::transaction(function () use ($articleDraft, $request) {
            $data = $request->validated();
            $articleDraft->update($data);
            $status = (int) $data['status'];
            if ($status === ArticleDraft::STATUS_PASS) {
                if ($articleDraft->article_id) {
                    $article = Article::find($articleDraft->article_id);
                    if (empty($article)) {
                        return $this->failed('参数有误');
                    }
                    $article->fill($articleDraft->toArray())->save();
                    $updated = true;
                }
                if (empty($updated)) {
                    $article = Article::create($articleDraft->toArray());
                    $articleDraft->update(['article_id' => $article->id]);
                }
            }
        });
        return $this->success();
    }
}
