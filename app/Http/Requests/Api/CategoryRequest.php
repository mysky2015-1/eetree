<?php

namespace App\Http\Requests\Api;

class CategoryRequest extends FormRequest
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
                    'name' => ['required', 'unique:category,name'],
                ];
            case 'PUT':
                return [
                    'parent_id' => ['required', 'numeric'],
                    'name' => ['required', 'unique:category,name,' . $this->category->id],
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
