<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AdminRoleRequest;
use App\Http\Resources\Api\AdminRoleResource;
use App\Models\AdminRole;
use DB;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        $roles = AdminRole::paginate(config('eetree.limit'));
        return $this->success(AdminRoleResource::collection($roles));
    }

    public function show(AdminRole $role)
    {
        return $this->success(new AdminRoleResource($role));
    }

    public function delete(AdminRole $role)
    {
        DB::transaction(function () use ($role) {
            $role->permissions()->detach();
            $role->menus()->detach();
            $role->admins()->detach();
            $role->delete();
        });
        return $this->success();
    }

    public function store(AdminRoleRequest $request)
    {
        AdminRole::create($request->validated());
        return $this->created();
    }

    public function update(AdminRole $role, AdminRoleRequest $request)
    {
        DB::transaction(function () use ($role, $request) {
            $permission_ids = $request->input('permission_id');
            $role->update($request->validated());
            $role->permissions()->sync($permission_ids);
        });
        return $this->success();
    }
}
