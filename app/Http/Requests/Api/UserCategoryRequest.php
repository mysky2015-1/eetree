<?php

namespace App\Http\Requests\Api;

class UserCategoryRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return [
                    'id' => ['required'],
                ];
            case 'POST':
                return [
                    'parent_id' => ['required', 'numeric'],
                    'name' => ['required'],
                ];
            case 'PUT':
                return [
                    'name' => ['required'],
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
            'name.required' => '名称不能为空',
            'parent_id.required' => '层级不能为空！',
        ];
    }
}
