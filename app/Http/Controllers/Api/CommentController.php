<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        $comments = Comment::with(['user', 'doc'])->paginate(config('eetree.adminLimit'));
        return $this->success(CommentResource::collection($comments));
    }

    public function toggle(Comment $comment)
    {
        if ($comment->active) {
            $active = 0;
        } else {
            $active = 1;
        }
        $comment->update(['active' => $active]);
        return $this->success(['active' => $active]);
    }
}
