<?php

namespace App\Http\Controllers;

use App\Models\Doc;
use Illuminate\Http\Request;

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
}
