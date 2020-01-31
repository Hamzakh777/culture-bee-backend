<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use Searchable;
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['owner'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'id' => $this->id,
            'job_title' => $this->job_title,
            'location' => $this->location,
            'industry' => $this->industry,
            'seniority' => $this->seniority,
            'type' => $this->type,
            'quick_pitch' => $this->quick_pitch,
            'tags' => $this->tags,
            'skills' => $this->skills,
            'why_this_role' => $this->why_this_role
        ];


        return $array;
    }

    public function owner() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
