<?php
namespace App\Services;

use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Support\Facades\Cache;

class SmsService
{
    public static function code($mobile, $key = 'default')
    {
        $code = 12345; //rand(10000, 99999);
        $config = config('sms.Aliyun');
        AlibabaCloud::accessKeyClient($config['accessKeyId'], $config['accessSecret'])
            ->regionId($config['RegionId'])
            ->asGlobalClient();

        try {
            //     $result = AlibabaCloud::rpcRequest()
            //         ->product('Dysmsapi')
            //     // ->scheme('https') // https | http
            //         ->version('2017-05-25')
            //         ->action('SendSms')
            //         ->method('POST')
            //         ->options([
            //             'query' => [
            //                 'PhoneNumbers' => $mobile,
            //                 'SignName' => $config['SignName'],
            //                 'TemplateCode' => $config['Template'][$key],
            //                 'TemplateParam' => json_encode(['code' => $code]),
            //             ],
            //         ])
            //         ->request();
            Cache::put(sprintf('smscode:mobile:%s:%s', $mobile, $key), $code, 300);
            return $code;
        } catch (ClientException $e) {
            Log::error('send-sms-code - ' . $e->getErrorMessage());
            return false;
        } catch (ServerException $e) {
            Log::error('send-sms-code - ' . $e->getErrorMessage());
            return false;
        }
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
