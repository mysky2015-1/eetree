<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'content' => $this->content,
            'active' => $this->active,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'user' => [
                'nickname' => $this->user->nickname,
            ],
            'doc' => [
                'title' => $this->doc->title,
            ],
        ];
    }
}
