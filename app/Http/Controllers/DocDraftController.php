<?php

namespace App\Http\Controllers;

use App\Api\Helpers\ApiResponse;
use App\Models\DocDraft;

class DocDraftController extends Controller
{
    use ApiResponse;

    public function edit(DocDraft $docDraft)
    {
        $render = $docDraft->toArray();
        return view('doc_draft/edit', $render);
    }
}
