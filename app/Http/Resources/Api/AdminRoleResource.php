<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminRoleResource extends JsonResource
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
        if ($routeName == 'adminrole.index') {
            $row['permissions'] = $this->permissions->map(function ($item, $key) {
                return $item->only(['id', 'name']);
            });
            $row['menus'] = $this->menus->pluck('menu_id');
        }
        return $row;
    }
}
