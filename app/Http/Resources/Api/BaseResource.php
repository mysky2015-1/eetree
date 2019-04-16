<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class BaseResource extends ResourceCollection
{

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource)
    {
        if ($resource instanceof LengthAwarePaginator) {
            $resource = $resource->getCollection();
        }
        parent::__construct($resource);
    }
}
