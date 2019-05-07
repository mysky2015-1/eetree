<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AdminPermissionRequest;
use App\Http\Resources\Api\AdminPermissionResource;
use App\Models\AdminPermission;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        if ($request->input('page')) {
            $permissions = AdminPermission::paginate(config('eetree.adminLimit'));
        } else {
            $permissions = AdminPermission::get();
        }
        return $this->success(AdminPermissionResource::collection($permissions));
    }

    public function show(AdminPermission $permission)
    {
        return $this->success(new AdminPermissionResource($permission));
    }

    public function delete(AdminPermission $permission)
    {
        \DB::transaction(function () use ($permission) {
            $permission->roles()->detach();
            $permission->delete();
        });
        return $this->success();
    }

    public function store(AdminPermissionRequest $request)
    {
        $permission = AdminPermission::create($request->validated());
        return $this->success(new AdminPermissionResource($permission));
    }

    public function update(AdminPermission $permission, AdminPermissionRequest $request)
    {
        $permission->update($request->validated());
        return $this->success();
    }
}
