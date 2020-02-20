<?php

namespace App;

use Overtrue\LaravelFollow\Traits\CanBeLiked;
use Illuminate\Database\Eloquent\Model;

class CompanyUpdate extends Model
{
    use CanBeLiked;
    
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
