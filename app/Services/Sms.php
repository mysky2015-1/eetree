<?php
namespace App\Services;

use Illuminate\Support\Facades\Redis;

// use Toplan\PhpSms\Sms as PhpSms;

class Sms
{
    public static function code($mobile, $key = 'default')
    {
        $code = rand(10000, 99999);
        $templates = config('eetree.sms');
        $result = PhpSms::make($templates[$key])->to($mobile)->data([$code])->send();
        if ($result === null || $result === true || (isset($result['success']) && $result['success'])) {
            Redis::setEx(sprintf('smscode:mobile:%s:%s', $mobile, $key), 3000, $code);
            return $code;
        }
        return false;
    }

    public static function verify($mobile, $code, $key = 'default')
    {
        if (Redis::get(sprintf('smscode:mobile:%s:%s', $mobile, $key)) == $code) {
            return true;
        } else {
            return false;
        }
    }

    public static function clear($mobile, $key = 'default')
    {
        Redis::del(sprintf('smscode:mobile:%s:%s', $mobile, $key));
    }
}
