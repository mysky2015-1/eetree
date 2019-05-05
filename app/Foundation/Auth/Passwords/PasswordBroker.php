<?php

namespace App\Foundation\Auth\Passwords;

use App\Services\Sms;
use Closure;
use Illuminate\Auth\Passwords\PasswordBroker as BasePasswordBroker;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\PasswordBroker as PasswordBrokerContract;
use Illuminate\Support\Arr;
use UnexpectedValueException;

class PasswordBroker extends BasePasswordBroker
{
    protected function validateReset(array $credentials)
    {
        if (is_null($user = $this->getUser($credentials))) {
            return PasswordBrokerContract::INVALID_USER;
        }

        if (!$this->validateNewPassword($credentials)) {
            return PasswordBrokerContract::INVALID_PASSWORD;
        }

        if (isset($credentials['verify_code'])) {
            //如果提交的字段含有verify_code表示是手机验证码方式重置密码，需要验证用户提交的验证码是不是刚才发送给他手机号的，验证码发送以后可以保持在缓存中
            if (Sms::verify($credentials['mobile'], $credentials['verify_code'])) {
                return PasswordBrokerContract::INVALID_TOKEN;
            }
        } elseif (!$this->tokens->exists($user, $credentials['token'])) {
            //邮件重置方式
            return PasswordBrokerContract::INVALID_TOKEN;
        }

        return $user;
    }

    /**
     * Get the user for the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\CanResetPassword
     *
     * @throws \UnexpectedValueException
     */
    public function getUser(array $credentials)
    {
        $credentials = Arr::except($credentials, ['token', 'verify_code']); //这里注意，如果是手机验证码方式找回密码需要吧verify_code字段排除，以免users表中没有verify_code字段查不到用户

        $user = $this->users->retrieveByCredentials($credentials);

        if ($user && !$user instanceof CanResetPasswordContract) {
            throw new UnexpectedValueException('User must implement CanResetPassword interface.');
        }

        return $user;
    }

    /**
     * 发送重置密码手机验证码
     *
     * @param  array $credentials
     * @param  \Closure|null $callback
     * @return string
     */
    public function sendResetCode(array $credentials, Closure $callback = null)
    {
        $user = $this->getUser($credentials);

        if (is_null($user)) {
            return PasswordBrokerContract::INVALID_USER;
        }
        $code = Sms::code($credentials['mobile']);
        if ($code) {
            return PasswordBrokerContract::RESET_LINK_SENT;
        }
    }

    /**
     * 通过手机验证码重置密码
     * @param array $credentials
     * @param Closure $callback
     * @return CanResetPasswordContract|string
     */
    public function resetByMobile(array $credentials, Closure $callback)
    {
        $user = $this->validateReset($credentials);

        if (!$user instanceof CanResetPasswordContract) {
            return $user;
        }

        $pass = $credentials['password'];

        call_user_func($callback, $user, $pass);
        //如果是手机号重置密码的话新密码保存后需要删除缓存的验证码
        Sms::clear($credentials['mobile']);

        return PasswordBrokerContract::PASSWORD_RESET;
    }

}
