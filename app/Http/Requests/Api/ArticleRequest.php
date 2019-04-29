<?php

namespace App\Http\Requests\Api;

class ArticleRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return [
                    'id' => ['required'],
                ];
            case 'PUT':
                return [
                    'title' => ['required'],
                    'content' => ['required'],
                ];
            case 'POST':
            case 'PATCH':
            case 'DELETE':
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            'title.required' => '标题不能为空',
            'content.required' => '内容不能为空',
        ];
    }
}
