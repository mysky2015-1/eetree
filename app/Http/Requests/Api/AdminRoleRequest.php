<?php

namespace App\Http\Requests\Api;

class AdminRoleRequest extends FormRequest
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
                    'name' => ['required', 'max:50', 'unique:admin_role,name'],
                ];
            case 'PUT':
                return [
                    'name' => ['required', 'max:50', 'unique:admin_role,name,' . $this->role->id],
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
        ];
    }
}
