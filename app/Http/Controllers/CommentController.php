<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Doc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use ApiResponse;

    public function index(Doc $doc, Request $request)
    {
        $comments = Comment::with(['user'])->where([
            ['doc_id', $doc->id],
            ['active', 1],
        ])->paginate(config('eetree.limit'));
        return $this->success(CommentResource::collection($comments));
    }

    public function store(Doc $doc, Request $request)
    {
        Comment::create([
            'doc_id' => $doc->id,
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'active' => 0,
        ]);
        return $this->success();
    }
}
