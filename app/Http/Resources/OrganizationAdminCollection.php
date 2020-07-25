<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Simple\OrganizationAdminResource;

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class OrganizationAdminCollection extends ResourceCollection
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
            'data' => OrganizationAdminResource::collection($this->collection),
        ];
    }
}
