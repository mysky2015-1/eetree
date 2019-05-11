<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class DocDraftResource extends JsonResource
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
            'submit_at' => $this->submit_at ? $this->submit_at->format('Y-m-d H:i:s') : '',
            'doc' => [
                'category_id' => $this->doc ? $this->doc->category_id : 0,
            ],
            'user' => [
                'nickname' => $this->user->nickname,
            ],
        ];
    }
}
