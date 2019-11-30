<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'url' => Storage::url($this->url),
            'speaker' => new SpeakerResource($this->whenLoaded('speaker')),
            'language' => new LanguageResource($this->whenLoaded('language')),
        ];
    }
}
