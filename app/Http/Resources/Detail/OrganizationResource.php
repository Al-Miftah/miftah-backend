<?php

namespace App\Http\Resources\Detail;

use App\Http\Resources\Simple\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'phone_number' => $this->phone_number,
            'digital_address' => $this->digital_address,
            'about' => $this->about,
            'is_active' => $this->active,
            'created_at' => $this->created_at,
            'admins' => UserResource::collection($this->admins),
        ];
    }
}
