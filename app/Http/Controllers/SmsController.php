<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Services\SmsService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    use ApiResponse;

    public function code(Request $request)
    {
        $mobile = $request->input('mobile');
        if (!preg_match('/^1[0-9]{10}$/', $mobile)) {
            return $this->error('手机格式有误');
        }
        $code = SmsService::code($mobile);
        if ($code) {
            return $this->success();
        } else {
            return $this->error('获取验证码失败');
        }
    }
}
