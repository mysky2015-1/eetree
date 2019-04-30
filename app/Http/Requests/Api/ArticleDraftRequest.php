<?php

namespace App\Http\Requests\Api;

use App\Models\ArticleDraft;

class ArticleDraftRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return [
                    'status' => ['required', 'in:' . implode(',', [ArticleDraft::STATUS_SUBMIT, ArticleDraft::STATUS_REFUSE])],
                ];
            case 'PUT':
                $rules = [
                    'status' => ['required', 'in:' . implode(',', [ArticleDraft::STATUS_REFUSE, ArticleDraft::STATUS_PASS])],
                ];
                if ($this->status == ArticleDraft::STATUS_REFUSE) {
                    $rules['review_remarks'] = ['required'];
                }
                return $rules;
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
            'status.in' => '审核状态不正确',
            'review_remarks.required' => '拒绝原因不能为空',
        ];
    }
}
