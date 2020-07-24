<?php

namespace App\Http\Resources;

use App\Http\Resources\Simple\SpeakerResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class SpeakerCollection extends ResourceCollection
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
            'data' => SpeakerResource::collection($this->collection),
        ];
    }
}
