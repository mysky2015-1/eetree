<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SmsController extends Controller
{
    use ApiResponse;

    public function code(Request $request)
    {
        $data = $request->all();
        $mobileRule = ['required', 'string', 'regex:/^1[0-9]{10}$/'];
        if ($data['tpl'] === 'register') {
            $mobileRule[] = 'unique:user';
        }
        Validator::make($data, [
            'mobile' => $mobileRule,
        ])->validate();
        $code = SmsService::code($data['mobile']);
        if ($code) {
            return $this->success();
        } else {
            return $this->error('获取验证码失败');
        }
    }
}
