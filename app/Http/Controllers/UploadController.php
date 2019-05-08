<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    use ApiResponse;

    public function docImage(Request $request)
    {
        $path = 'doc_file/1/oTvyEIUnwdnJwQlJeRphtPlz38tOKFjYuSbSw5H5.jpeg';
        return ['url' => Storage::url('file.jpg')];
        $this->validate($request, [
            'upload_file' => 'required|image',
        ], [
            'upload_file.required' => '请先选择要上传的图片',
        ]);
        $file = $request->file('upload_file');

        if ($file->isValid()) {
            $path = $file->store(
                'doc_file/' . $request->user()->id, 'public'
            );
        }

        return $path;
    }
}
