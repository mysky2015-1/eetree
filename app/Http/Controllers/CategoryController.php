<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Doc;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Category $category, Request $request)
    {
        $params = $request->all();
        $params['category_id'] = $category->id;
        $docs = Doc::search($params);

        return view('doc/index', [
            'docs' => $docs,
        ]);
    }
}
