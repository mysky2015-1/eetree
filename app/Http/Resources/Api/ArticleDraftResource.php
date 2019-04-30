<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleDraftResource extends JsonResource
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
            'submit_at' => $this->created_at->format('Y-m-d H:i:s'),
            'user' => [
                'nickname' => $this->user->nickname,
            ],
        ];
    }
}
