<?php

namespace App\Http\Resources\Detail;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class SpeechResource extends JsonResource
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
            'summary' => $this->summary,
            'transcription' => $this->transcription,
            'url' => $this->url,
            'created_at' => $this->created_at->diffForHumans(),
            'speaker' => new SpeakerResource($this->whenLoaded('speaker')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
