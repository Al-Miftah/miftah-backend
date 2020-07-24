<?php

namespace App\Http\Resources;

use App\Http\Resources\Simple\DonationResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DonationCollection extends ResourceCollection
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
            'data' => DonationResource::collection($this->collection),
        ];
    }
}
