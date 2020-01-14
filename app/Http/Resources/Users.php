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
            'coverImgUrl' => $this->cover_img_url,
            'quickPitch' => $this->quick_pitch,
            'role' => $this->roles->pluck('name')
        ];
    }
}
