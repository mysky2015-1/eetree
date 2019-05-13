<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\DocDraft;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocDraftController extends Controller
{
    use ApiResponse;

    public function edit(DocDraft $docDraft)
    {
        $checked = $this->_checkDoc($docDraft);
        if ($checked !== true) {
            return $checked;
        }
        return view('doc_draft/edit', [
            'docDraft' => $docDraft->toArray(),
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $docDraft = new DocDraft;
        $docDraft->user_id = $userId;
        $docDraft->title = '新建文档';
        $docDraft->content = '';
        $docDraft->review_remarks = '';
        $docDraft->save();

        return $this->success([
            'url' => route('docDraft.edit', ['docDraft' => $docDraft->id]),
        ]);
    }

    public function save(DocDraft $docDraft, Request $request)
    {
        $userId = Auth::id();
        $content = $request->input('content');
        if (!isset($content['root']['data']['text'])) {
            return $this->failed('error');
        }
        $title = $content['root']['data']['text'];
        $checked = $this->_checkDoc($docDraft);
        if ($checked !== true) {
            return $checked;
        }
        $docDraft->title = $title;
        $docDraft->content = $content;
        $docDraft->save();

        return $this->success([
            'url' => route('docDraft.edit', ['docDraft' => $docDraft->id]),
        ]);
    }

    public function share(DocDraft $docDraft)
    {
        $checked = $this->_checkDoc($docDraft);
        if ($checked !== true) {
            return $checked;
        }
        $docDraft->submitShare();

        return $this->success();
    }

    public function delete(DocDraft $docDraft)
    {
        $checked = $this->_checkDoc($docDraft);
        if ($checked !== true) {
            return $checked;
        }
        $docDraft->delete();

        return $this->success();
    }

    private function _checkDoc($docDraft)
    {
        $userId = Auth::id();
        if ($docDraft->user_id != $userId) {
            return $this->failed('无权限');
        }
        if ($docDraft->status == DocDraft::STATUS_SUBMIT) {
            return $this->failed('审核中，不能修改');
        }
        return true;
    }
}
