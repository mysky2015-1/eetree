<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use Illuminate\Http\Request;

class DocController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->input('q');
        $docs = Doc::where([
            ['publish_at', '>', 0],
            ['title', 'like', '%' . $q . '%'],
        ])->paginate(config('eetree.limit'));

        return view('doc/search', [
            'docs' => $docs,
        ]);
    }

    public function detail(Doc $doc)
    {
        $doc->content = json_decode($doc->content, true);
        return view('doc/detail', [
            'doc' => $doc,
        ]);
    }
}
