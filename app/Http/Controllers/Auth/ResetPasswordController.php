<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
     */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * 通过短信验证码重置密码
     * @param MobileResetPasswordRequest $request
     * @return array
     */
    public function resetByMobile(MobileResetPasswordRequest $request)
    {
        $credentials = $request->only('mobile', 'password', 'password_confirmation', 'verify_code');

        $broker = $this->getBroker();

        $response = Password::broker($broker)->resetByMobile($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });

        switch ($response) {
            case Password::PASSWORD_RESET:
                unset($credentials['verify_code']);
                unset($credentials['password_confirmation']);
                return [
                    'status_code' => '200',
                    'message' => '密码重置成功',
                ];

            case Password::INVALID_TOKEN:
            //返回'手机验证码已失效'

            default:
                //返回'密码重置失败'
        }
    }
}
