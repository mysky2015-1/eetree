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
        $permissions = AdminPermission::paginate(config('eetree.limit'));
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
        AdminPermission::create($request->all());
        return $this->created();
    }

    public function update(AdminPermission $permission, AdminPermissionRequest $request)
    {
        $permission->update($request->all());
        return $this->success();
    }
}