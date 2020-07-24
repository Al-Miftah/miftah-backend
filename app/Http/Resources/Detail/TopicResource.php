<?php

namespace App\Http\Resources\Detail;

use App\Http\Resources\Simple\SpeechResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class TopicResource extends JsonResource
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
            'description' => $this->description,
            'speeches' => SpeechResource::collection($this->whenLoaded('speeches')),
        ];
    }
}
