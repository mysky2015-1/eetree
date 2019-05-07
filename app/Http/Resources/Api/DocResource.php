<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class DocResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'published' => $this->publish_at === null ? 0 : 1,
            'user' => [
                'nickname' => $this->user->nickname,
            ],
        ];
    }
}
