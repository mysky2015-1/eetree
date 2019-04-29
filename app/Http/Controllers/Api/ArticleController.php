<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ArticleRequest;
use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        $articles = Article::with('user')->where('deleted', 0)->paginate(config('eetree.limit'));
        return $this->success(ArticleResource::collection($articles));
    }

    public function delete(Article $article)
    {
        $article->update(['deleted' => 1]);
        return $this->success();
    }

    public function update(Article $article, ArticleRequest $request)
    {
        $article->update($request->validated());
        return $this->success();
    }
}
