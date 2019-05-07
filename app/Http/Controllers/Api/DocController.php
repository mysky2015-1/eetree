<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\DocRequest;
use App\Http\Resources\Api\DocResource;
use App\Models\Doc;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DocController extends Controller
{
    //返回文档列表
    public function index(Request $request)
    {
        $docs = Doc::with('user')->paginate(config('eetree.limit'));
        return $this->success(DocResource::collection($docs));
    }

    private function publish($doc)
    {
        if ($doc->publish_at > 0) {
            return $this->failed('失败，已是上线状态');
        }
        $doc->publish_at = Carbon::now();
        $doc->save();
        return $this->success();
    }

    private function unpublish($doc)
    {
        if ($doc->publish_at === 0) {
            return $this->failed('失败，已是下线状态');
        }
        $doc->publish_at = null;
        $doc->save();
        return $this->success();
    }

    public function update(Doc $doc, DocRequest $request)
    {
        $publish = (int) $request->input('publish');
        if ($publish === 1) {
            return $this->publish($doc);
        } elseif ($publish === 0) {
            return $this->unpublish($doc);
        }
        $doc->update($request->validated());
        return $this->success();
    }
}
