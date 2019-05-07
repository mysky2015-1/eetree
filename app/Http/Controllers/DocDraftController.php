<?php

namespace App\Http\Controllers;

use App\Api\Helpers\ApiResponse;
use App\Models\DocDraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocDraftController extends Controller
{
    use ApiResponse;

    public function edit(DocDraft $docDraft = null)
    {
        if ($docDraft) {
            $userId = Auth::id();

            if ($docDraft->user_id != $userId) {
                abort(403);
            }
            return view('doc_draft/edit', [
                'docDraft' => $docDraft->toArray(),
            ]);
        } else {
            return view('doc_draft/edit');
        }
    }

    public function save(DocDraft $docDraft = null, Request $request)
    {
        $userId = Auth::id();
        $content = $request->input('content');
        if (!isset($content['root']['data']['text'])) {
            return $this->failed('error');
        }
        $title = $content['root']['data']['text'];
        if ($docDraft) {
            if ($docDraft->user_id != $userId) {
                $this->failed('无权限');
            }
            $docDraft->title = $title;
            $docDraft->content = $content;
            $docDraft->save();
        } else {
            $docDraft = new DocDraft;
            $docDraft->user_id = $userId;
            $docDraft->review_remarks = '';
        }
        $docDraft->title = $title;
        $docDraft->content = $content;
        $docDraft->save();

        return $this->success([
            'url' => route('docDraft.edit', ['docDraft' => $docDraft->id]),
            'saveUrl' => route('docDraft.save', ['docDraft' => $docDraft->id]),
        ]);
    }
}
