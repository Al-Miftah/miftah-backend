<?php

namespace App\Http\Resources;

use App\Http\Resources\Simple\TagResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class TagCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => TagResource::collection($this->collection),
        ];
    }
}
