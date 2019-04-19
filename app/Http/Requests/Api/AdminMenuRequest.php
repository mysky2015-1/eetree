<?php

namespace App\Http\Requests\Api;

class AdminMenuRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return [
                    'id' => ['required'],
                ];
            case 'POST':
            case 'PUT':
                return [
                    'parent_id' => ['required', 'numeric'],
                    'title' => ['required'],
                    'uri' => ['required'],
                ];
            case 'PATCH':
            case 'DELETE':
            default:
                return [];
        }
    }

    public function messages()
    {
        return [
            'title.required' => '名称不能为空',
            'parent_id.required' => '层级不能为空！',
            'uri.required' => '链接不能为空！',
        ];
    }
}
