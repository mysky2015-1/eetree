<?php

namespace App\Http\Requests\Api;

class ArticleDraftRequest extends FormRequest
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
                    'status' => ['required', 'in:8,9'],
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
            'status.required' => '审核状态不能为空',
            'status.in' => '审核不正确',
        ];
    }
}
