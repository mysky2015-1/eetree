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
        $this->_checkDoc($docDraft);
        return view('doc_draft/edit', [
            'docDraft' => $docDraft->toArray(),
        ]);
    }

    public function share(DocDraft $docDraft)
    {
        if ($docDraft->share_id === '') {
            abort(404);
        }
        return view('doc/detail', [
            'doc' => $docDraft,
        ]);
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $docDraft = new DocDraft;
        $docDraft->user_id = $userId;
        $docDraft->title = '新建文档';
        $docDraft->content = '';
        $docDraft->user_category_id = (int) $request->input('user_category_id');
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
        $this->_checkDoc($docDraft);
        $docDraft->title = $title;
        $docDraft->content = $content;
        $docDraft->save();

        return $this->success([
            'url' => route('docDraft.edit', ['docDraft' => $docDraft->id]),
        ]);
    }

    public function move(DocDraft $docDraft, Request $request)
    {
        $userId = Auth::id();
        $this->_checkDoc($docDraft);
        $destId = (int) $request->input('dest');
        if ($docDraft->user_category_id === $destId) {
            return $this->failed('参数有误');
        }
        if ($destId !== 0) {
            $destCategory = UserCategory::find($destId);
            if ($destCategory->user_id !== $userId) {
                return $this->failed('参数有误');
            }
        }
        $docDraft->user_category_id = $destId;
        $docDraft->save();

        return $this->success();
    }

    public function setShare(DocDraft $docDraft)
    {
        $this->_checkDoc($docDraft);
        $docDraft->setShare();

        return $this->success();
    }

    public function publish(DocDraft $docDraft)
    {
        $this->_checkDoc($docDraft);
        $docDraft->setPublish();

        return $this->success();
    }

    public function delete(DocDraft $docDraft)
    {
        $this->_checkDoc($docDraft);
        $docDraft->delete();

        return $this->success();
    }

    private function _checkDoc($docDraft)
    {
        $userId = Auth::id();
        if ($docDraft->user_id != $userId) {
            abort(403);
        }
    }
}
