<?php

namespace App\Http\Resources\Simple;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class SpeakerResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
        ];
    }
}
