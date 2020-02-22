<?php

namespace App;

use Laravel\Scout\Searchable;
use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Illuminate\Database\Eloquent\Model;

class CompanyUpdate extends Model
{
    use CanBeLiked, Searchable;
    
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
