<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ArticleRequest;
use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        $articles = Article::with('user')->paginate(config('eetree.limit'));
        return $this->success(ArticleResource::collection($articles));
    }

    private function publish($article)
    {
        if ($article->publish_at > 0) {
            return $this->failed('失败，已是上线状态');
        }
        $article->publish_at = Carbon::now();
        $article->save();
        return $this->success();
    }

    private function unpublish($article)
    {
        if ($article->publish_at === 0) {
            return $this->failed('失败，已是下线状态');
        }
        $article->publish_at = null;
        $article->save();
        return $this->success();
    }

    public function update(Article $article, ArticleRequest $request)
    {
        $publish = (int) $request->input('publish');
        if ($publish === 1) {
            return $this->publish($article);
        } elseif ($publish === 0) {
            return $this->unpublish($article);
        }
        $article->update($request->validated());
        return $this->success();
    }
}
