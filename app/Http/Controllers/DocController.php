<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use Illuminate\Http\Request;

class DocController extends Controller
{
    public function detail(Doc $doc)
    {
        $doc->countPlus('view_count');
        return view('doc/detail', [
            'doc' => $doc,
        ]);
    }

    public function search(Request $request)
    {
        $q = $request->input('q');
        $where = [
            ['publish_at', '>', 0],
        ];
        if (!empty($q)) {
            $where[] = ['title', 'like', '%' . $q . '%'];
        }
        $docs = Doc::where($where)->paginate(config('eetree.limit'));

        return view('doc/search', [
            'docs' => $docs,
        ]);
    }
}
