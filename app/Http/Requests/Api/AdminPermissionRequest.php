<?php

namespace App\Http\Requests\Api;

class AdminPermissionRequest extends FormRequest
{
    public function rules()
    {
        $model = $this->route('permission');
        switch ($this->method()) {
            case 'GET':
                return [
                    'id' => ['required'],
                ];
            case 'POST':
                return [
                    'name' => ['required', 'max:50', 'unique:admin_permissions,name,' . $model->id],
                    'http_method' => ['required'],
                    'http_path' => ['required'],
                ];
            case 'PUT':
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
            'http_method.required' => 'Http方法不能为空！',
            'http_path.required' => 'Http路径不能为空！',
        ];
    }
}
