<?php

namespace App\Http\Resources;

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
            'doc_id' => $this->doc_id,
            'title' => $this->title,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
