<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class AdminResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $row = [
            'id' => $this->id,
            'name' => $this->name,
        ];
        $routeName = $request->route()->getName();
        if ($routeName == 'admin.info') {
            $row['menus'] = $this->roleMenus();
            $row['avatar'] = URL::asset('img/default-avatar.gif');
        } elseif ($routeName == 'admin.list') {
            $row['created_at'] = $this->created_at->format('Y-m-d H:i:s');
            $row['roles'] = $this->roles->map(function ($item, $key) {
                return $item->only(['id', 'name']);
            });
        } elseif ($routeName == 'admin.store') {
            $row['created_at'] = $this->created_at->format('Y-m-d H:i:s');
        }
        return $row;
    }
}
