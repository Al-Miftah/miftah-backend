<?php

namespace App\Http\Resources\Detail;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Simple\{PermissionResource, RoleResource};

/**
 * @author Ibrahim Samad <naatogma@gmail.com>
 */
class UserResource extends JsonResource
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
            'email' => $this->email,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'joined_on' => $this->created_at->format('Y-m-d'),
            //Distinct to prevent duplicate roles or permissions for both web & api guards
            'permissions' => PermissionResource::collection($this->permissions()->distinct('name')->get()),
            'roles' => RoleResource::collection($this->roles()->distinct('name')->get()),
        ];
    }
}
