<?php

namespace App\Http\Requests\Api;

class AdminRoleRequest extends FormRequest
{
    public function rules()
    {
        $model = $this->route('role');
        switch ($this->method()) {
            case 'GET':
                return [
                    'id' => ['required'],
                ];
            case 'POST':
                return [
                    'name' => ['required', 'max:50', 'unique:admin_roles,name,' . $model->id],
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
        ];
    }
}
