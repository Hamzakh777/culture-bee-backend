<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    public function owner() {
        return $this->belongsTo('App\User', 'user_id');
    }
}
