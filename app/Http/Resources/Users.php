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
        $user = auth()->user();

        return [
            'id' => $this->id,
            'location' => $this->location,
            'email' => $this->email,
            'name' => $this->name,
            'companyName' => $this->company_name,
            'profileImgUrl' => $this->profile_img_url,
            'coverImgUrl' => $this->cover_img_url,
            'quickPitch' => $this->quick_pitch,
            'currentProfileCreationStep' => $this->current_profile_creation_step,
            'role' => $this->roles->pluck('name')->first(),
            'user' => $user,
            'following' => $user === null ? false : $user->isFollowing($this->id)
        ];
    }
}
