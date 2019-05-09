<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\File;
use Illuminate\Http\Request;
use Validator;

class UploadController extends Controller
{
    use ApiResponse;

    public function docImage(\App\Models\DocDraft $docDraft, Request $request)
    {
        $maxSize = config('eetree.upload.max');
        $validator = Validator::make($request->all(), [
            'upload_file' => 'required|image|max:' . $maxSize,
        ], [
            'upload_file.required' => '请先选择要上传的图片',
            'upload_file.max' => '上传文件大小不能超过 ' . $maxSize . 'KB',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return [
                'errno' => 400,
                'msg' => $errors->first('upload_file'),
            ];
        }

        $file = $request->file('upload_file');

        $path = $file->store(
            'doc_file/' . $request->user()->id, 'public'
        );
        File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'type' => 'doc-image',
            'mime' => $file->getMimeType(),
            'pid' => $docDraft->id,
        ]);

        return [
            'errno' => 0,
            'msg' => 'ok',
            'data' => [
                'url' => asset('storage/' . $path),
            ],
        ];
    }
}
