<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\DocPublishRequest;
use App\Http\Resources\Api\DocPublishResource;
use App\Models\Doc;
use App\Models\DocPublish;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DocPublishController extends Controller
{
    //返回菜单列表
    public function index(DocPublishRequest $request)
    {
        $docPublishs = DocPublish::with(['user', 'doc'])
            ->where('status', $request->input('status'))
            ->orderBy('created_at', 'desc')
            ->paginate(config('eetree.adminLimit'));
        return $this->success(DocPublishResource::collection($docPublishs));
    }

    public function previewKey(DocPublish $docPublish)
    {
        Cache::put('DocPublish:preview:' . $docPublish->id, 1, 60);
        return $this->success(['url' => route('doc.publishPreview', ['docPublish' => $docPublish->id])]);
    }

    public function review(DocPublish $docPublish, DocPublishRequest $request)
    {
        if (!in_array($docPublish->status, [DocPublish::STATUS_SUBMIT, DocPublish::STATUS_REFUSE])) {
            return $this->failed('参数有误');
        }
        \DB::transaction(function () use ($docPublish, $request) {
            $data = $request->validated();
            $docPublish->update($data);
            $status = (int) $data['status'];
            if ($status === DocPublish::STATUS_PASS) {
                if ($docPublish->doc_id) {
                    $doc = Doc::find($docPublish->doc_id);
                    if (empty($doc)) {
                        return $this->failed('参数有误');
                    }
                    $doc->fill($docPublish->toArray());
                    $doc->publish_at = Carbon::now();
                    $doc->category_id = $data['category_id'];
                    $doc->save();
                } else {
                    $row = $docPublish->toArray();
                    $doc = new Doc;
                    $doc->fill($row);
                    $doc->user_id = $row['user_id'];
                    $doc->category_id = $data['category_id'];
                    $doc->publish_at = Carbon::now();
                    $doc->save();
                    $docPublish->update(['doc_id' => $doc->id]);
                    DocDraft::where('publish_id', $docPublish->id)->update(['doc_id' => $doc->id]);
                }
            }
        });
        return $this->success();
    }
}
