<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Users extends JsonResource
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
            'location' => $this->location,
            'email' => $this->email,
            'name' => $this->name,
            'companyName' => $this->company_name,
            'profileImgUrl' => $this->profile_img_url,
            'role' => $this->roles->pluck('name')
        ];
    }
}
