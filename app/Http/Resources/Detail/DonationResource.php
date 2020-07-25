<?php

namespace App\Http\Resources\Detail;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class DonationResource extends JsonResource
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
            'amount' => $this->amount,
            'gateway' => $this->gateway,
            'currency' => $this->currency,
            'channel' => $this->channel,
            'additional_information' => $this->additional_information,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'donated_by' => ($this->donor) ? $this->donor->only(['id', 'name']): null,
            'donated_for' => $this->organization->only(['id', 'name']),
        ];
    }
}
