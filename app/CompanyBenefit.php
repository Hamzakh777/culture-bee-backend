<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyBenefit extends Model
{
    public function owner() {
        return $this->belongTo('App\User', 'user_id');
    }
}
