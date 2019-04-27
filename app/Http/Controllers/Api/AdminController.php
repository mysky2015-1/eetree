<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AdminRequest;
use App\Http\Resources\Api\AdminResource;
use App\Jobs\Api\SaveLastTokenJob;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AdminController extends Controller
{
    //返回用户列表
    public function index(Request $request)
    {
        $name = $request->input('name');
        $where = [['deleted', 0]];
        if (!empty($name)) {
            $where[] = ['name', 'like', '%' . $name . '%'];
        }
        $admins = Admin::where($where)->paginate(config('eetree.limit'));
        return $this->success(AdminResource::collection($admins));
    }

    //返回单一用户信息
    public function show(Admin $admin)
    {
        return $this->success(new AdminResource($admin));
    }

    //删除用户
    public function delete(Admin $admin)
    {
        if ($admin->id == 1) {
            return $this->failed('该用户是超级管理员');
        }
        $admin->update(['deleted' => 1]);
        return $this->success();
    }

    public function update(Admin $admin, AdminRequest $request)
    {
        \DB::transaction(function () use ($admin, $request) {
            $role_ids = $request->input('roles');
            $data = $request->validated();
            if (isset($data['password']) && empty($data['password'])) {
                unset($data['password']);
            }
            if (!empty($data)) {
                $admin->update($data);
            }
            $admin->roles()->sync($role_ids);
        });
        return $this->success();
    }

    //返回当前登录用户信息
    public function info()
    {
        $admin = Auth::user();
        return $this->success(new AdminResource($admin));
    }

    //用户注册
    public function store(AdminRequest $request)
    {
        $admin = Admin::create($request->validated());
        return $this->success(new AdminResource($admin));
    }

    //用户登录
    public function login(Request $request)
    {
        //获取当前守护的名称
        $present_guard = Auth::getDefaultDriver();
        $token = Auth::claims(['guard' => $present_guard])->attempt(['name' => $request->name, 'password' => $request->password]);
        if ($token) {
            //如果登陆，先检查原先是否有存token，有的话先失效，然后再存入最新的token
            $user = Auth::user();
            if ($user->last_token) {
                try {
                    Auth::setToken($user->last_token)->invalidate();
                } catch (TokenExpiredException $e) {
                    //因为让一个过期的token再失效，会抛出异常，所以我们捕捉异常，不需要做任何处理
                }
            }
            SaveLastTokenJob::dispatch($user, $token);
            return $this->success(['token' => 'bearer ' . $token]);
        }
        return $this->failed('账号或密码错误', 400);
    }

    //用户退出
    public function logout()
    {
        Auth::logout();
        return $this->success('退出成功...');
    }
}
