<?php

namespace App\Http\Resources\Detail;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class TagResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'speeches' => SpeechResource::collection($this->whenLoaded('speeches')),
        ];
    }
}
