<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Toplan\PhpSms\Sms as PhpSms;

class SmsService
{
    public static function code($mobile, $key = 'default')
    {
        $code = rand(10000, 99999);
        $templates = config('eetree.sms');
        $result = PhpSms::make($templates[$key])->to($mobile)->data([$code])->send();
        if ($result === null || $result === true || (isset($result['success']) && $result['success'])) {
            Cache::put(sprintf('smscode:mobile:%s:%s', $mobile, $key), $code, 300);
            return $code;
        }
        return false;
    }

    public static function verify($mobile, $code, $key = 'default')
    {
        if (Cache::get(sprintf('smscode:mobile:%s:%s', $mobile, $key)) == $code) {
            return true;
        } else {
            return false;
        }
    }

    public static function clear($mobile, $key = 'default')
    {
        Cache::forget(sprintf('smscode:mobile:%s:%s', $mobile, $key));
    }
}
