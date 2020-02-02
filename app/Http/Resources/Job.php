<?php

namespace App\Http\Resources;

use \Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Job extends JsonResource
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
            'seniority' => $this->seniority,
            'industry' => $this->industry,
            'type' => $this->type,
            'jobTitle' => $this->job_title,
            'quickPitch' => $this->quick_pitch,
            'applicationUrl' => $this->application_url,
            'applicationEmail' => $this->application_email,
            'tags' => json_decode($this->tags),
            'skills' => json_decode($this->skills),
            'whyThisRole' => $this->why_this_role,
            'ownershipValues' => json_decode($this->ownership_values),
            'applicantQualities' => json_decode($this->applicant_qualities),
            'promoPhotoUrl' => $this->promo_photo_url,
            'aboutTheColleagues' => $this->about_the_colleagues,
            'familyPhotoUrl' => $this->family_photo_url,
            'isUnexpired' => $this->is_unexpired,
            'createdAt' => Carbon::parse($this->created_at)->calendar(),
            'userId' => $this->user_id,
            'owner' => $this->owner
        ];
    }
}
