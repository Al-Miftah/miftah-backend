<?php

namespace App\Http\Resources\Simple;

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
        ];
    }
}
