<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AdminMenuRequest;
use App\Http\Resources\Api\AdminMenuResource;
use App\Models\AdminMenu;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        $menus = AdminMenu::paginate(config('eetree.limit'));
        return $this->success(AdminMenuResource::collection($menus));
    }

    //返回单一菜单信息
    public function show(AdminMenu $menu)
    {
        return $this->success(new AdminMenuResource($menu));
    }

    //删除菜单
    public function delete(AdminMenu $menu)
    {
        $all = AdminMenu::orderBy('order', 'asc')->get();
        $all = AdminMenuResource::tree($all);
        $subTree = AdminMenuResource::subTree($all, $menu->id);
        dd($menu->id, $subTree);exit;
        DB::transaction(function () {
            //TODO update batch
            DB::table('admin_role_menu')->whereIn('menu_id', $deleteIds)->delete();
            AdminMenu::whereIn('id', $deleteIds)->delete();
        });

        return $this->success();
    }

    //保存菜单
    public function store(AdminMenuRequest $request)
    {
        AdminMenu::create($request->all());
        return $this->created();
    }
}
