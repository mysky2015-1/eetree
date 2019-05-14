<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocResource;
use App\Models\Doc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DocController extends Controller
{
    public function index(Request $request)
    {
        $docs = Doc::search($request->all());
        return view('doc/index', [
            'docs' => $docs,
        ]);
    }

    public function detail(Doc $doc)
    {
        $doc->countPlus('view_count');
        return view('doc/detail', [
            'doc' => $doc,
        ]);
    }

    public function publishPreview(\App\Models\DocPublish $docPublish)
    {
        $value = Cache::pull('DocPublish:preview:' . $docPublish->id);
        if (!$value) {
            abort(404);
        }
        return view('doc/preview', [
            'doc' => $docPublish,
        ]);
    }

    public function doclist(Request $request)
    {
        $q = $request->input('q');
        $where = [];
        if (!empty($q)) {
            $where[] = ['title', 'like', '%' . $q . '%'];
        }
        $docs = Doc::where($where)->paginate(config('eetree.limit'));
        return $this->success(DocResource::collection($docs));
    }
}
