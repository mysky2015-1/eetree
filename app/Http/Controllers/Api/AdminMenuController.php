<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Tree;
use App\Http\Requests\Api\AdminMenuRequest;
use App\Http\Resources\Api\AdminMenuResource;
use App\Models\AdminMenu;
use DB;
use Illuminate\Http\Request;

class AdminMenuController extends Controller
{
    //返回菜单列表
    public function index(Request $request)
    {
        $menus = AdminMenu::orderBy('order', 'asc')->get();
        $menus = Tree::make($menus);
        return $this->success(AdminMenuResource::collection($menus));
    }

    //删除菜单
    public function delete(AdminMenu $menu)
    {
        $all = AdminMenu::orderBy('order', 'asc')->get();
        $all = Tree::make($all);
        $subTree = Tree::children($all, $menu->id);
        $deleteIds = Tree::ids($subTree);
        $siblings = Tree::siblings($all, $menu);
        $deleteIds[] = $menu->id;
        DB::transaction(function () use ($siblings, $deleteIds) {
            //TODO update batch
            $siblings->each(function ($item, $key) {
                if ($item->order != $key) {
                    AdminMenu::where('id', $item->id)->update(['order' => $key]);
                }
            });
            DB::table('admin_role_menu')->whereIn('menu_id', $deleteIds)->delete();
            AdminMenu::whereIn('id', $deleteIds)->delete();
        });

        return $this->success();
    }

    public function store(AdminMenuRequest $request)
    {
        $data = $request->all();
        $data['order'] = AdminMenu::where('parent_id', $data['parent_id'])->count();
        AdminMenu::create($data);
        return $this->created();
    }

    public function update(AdminMenu $menu, AdminMenuRequest $request)
    {
        $data = $request->all();
        $menu->update($data);
        return $this->success();
    }
}
