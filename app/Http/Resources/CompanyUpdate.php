<?php

namespace App\Http\Resources;

use App\Http\Resources\Users;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyUpdate extends JsonResource
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
            'description' => $this->description,
            'tags' => json_decode($this->tags),
            'isPinned' => (int)$this->is_pinned,
            'imgUrl' => $this->img_url,
            'owner' => new Users($this->owner),
            'isLiked' => $this->isLikedBy(auth()->user()),
            'likes' => $this->likers
        ];
    }
}
