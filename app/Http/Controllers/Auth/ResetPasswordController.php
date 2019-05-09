<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SmsService;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Validator;

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

    protected function rules()
    {
        return [
            'password' => 'required|confirmed|min:8',
        ];
    }

    public function resetByMobile(Request $request)
    {
        if (empty($request->password)) {
            if (!SmsService::verify($request->input('mobile'), $request->input('verify_code'))) {
                return back()
                    ->withInput($request->only('mobile'))
                    ->withErrors(['verify_code' => '验证码错误']);
            }
            return view('auth.passwords.reset')->with($request->only('mobile', 'verify_code'));
        } else {
            $validator = Validator::make($request->all(), $this->rules(), $this->validationErrorMessages());
            if ($validator->fails()) {
                return view('auth.passwords.reset')
                    ->with($request->only('mobile', 'verify_code'))
                    ->withErrors($validator);
            }

            $credentials = $request->only('mobile', 'password', 'password_confirmation', 'verify_code');
            $response = $this->resetBroker($credentials, function ($user, $password) {
                $this->resetPassword($user, $password);
            });
            return $response == Password::PASSWORD_RESET ? $this->sendResetResponse($request, $response) : $this->sendResetFailedResponse($request, $response);
        }
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        if ($response == '验证码过期') {
            $error = ['verify_code' => trans($response)];
        } else {
            $error = ['mobile' => trans($response)];
        }
        return redirect()->back()
            ->withInput($request->only('mobile'))
            ->withErrors($error);
    }

    protected function resetBroker(array $credentials, $callback)
    {
        $user = \App\Models\User::where('mobile', $credentials['mobile'])->first();
        if (empty($user)) {
            return '找不到该用户';
        }
        if (!SmsService::verify($credentials['mobile'], $credentials['verify_code'])) {
            return '验证码过期';
        }
        $pass = $credentials['password'];
        call_user_func($callback, $user, $pass);

        SmsService::clear($credentials['mobile']);
        return PasswordBroker::PASSWORD_RESET;
    }
}
