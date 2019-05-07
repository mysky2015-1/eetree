<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\DocDraftRequest;
use App\Http\Resources\Api\DocDraftResource;
use App\Models\Doc;
use App\Models\DocDraft;
use Carbon\Carbon;

class DocDraftController extends Controller
{
    //返回菜单列表
    public function index(DocDraftRequest $request)
    {
        $docDrafts = DocDraft::with('user')
            ->where('status', $request->input('status'))
            ->paginate(config('eetree.adminLimit'));
        var_dump($docDrafts);exit;
        return $this->success(DocDraftResource::collection($docDrafts));
    }

    public function review(DocDraft $docDraft, DocDraftRequest $request)
    {
        if (!in_array($docDraft->status, [DocDraft::STATUS_SUBMIT, DocDraft::STATUS_REFUSE])) {
            return $this->failed('参数有误');
        }
        \DB::transaction(function () use ($docDraft, $request) {
            $data = $request->validated();
            $docDraft->update($data);
            $status = (int) $data['status'];
            if ($status === DocDraft::STATUS_PASS) {
                if ($docDraft->doc_id) {
                    $doc = Doc::find($docDraft->doc_id);
                    if (empty($doc)) {
                        return $this->failed('参数有误');
                    }
                    $doc->fill($docDraft->toArray());
                    $doc->publish_at = Carbon::now();
                    $doc->save();
                    $updated = true;
                }
                if (empty($updated)) {
                    $row = $docDraft->toArray();
                    $doc = Doc::create($row);
                    $doc->user_id = $row['user_id'];
                    $doc->publish_at = Carbon::now();
                    $doc->save();
                    $docDraft->update(['doc_id' => $doc->id]);
                }
            }
        });
        return $this->success();
    }
}
