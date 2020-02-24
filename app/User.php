<?php

namespace App;

use Carbon\Carbon;
use Laravel\Scout\Searchable;
use Overtrue\LaravelFollow\Traits\CanFollow;
use Overtrue\LaravelFollow\Traits\CanBeFollowed;
use Overtrue\LaravelFollow\Traits\CanLike;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use CanLike, CanBeFollowed, CanFollow, HasRoles, HasApiTokens, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'skills' => 'array'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = [
            'id' => $this->id,
            'role' => $this->roles->pluck('name')->first(),
            'quick_pitch' => $this->quick_pitch,
            'location' => $this->location,
            'email' => $this->email,
            'name' => $this->name,
            'companyName' => $this->company_name,
            'industry' => $this->industry,
            'created_at' => $this->created_at,
            'created_at_timestamp' => Carbon::parse($this->created_at)->timestamp
        ];


        return $array;
    }

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    public function values() {
        return $this->hasMany('App\CompanyValue', 'user_id');
    }

    public function updates()
    {
        return $this->hasMany('App\CompanyUpdate', 'user_id');
    }

    public function benefits() {
        return $this->hasMany('App\CompanyBenefit', 'user_id');
    }

    public function companyVision()
    {
        return $this->hasOne('App\CompanyVision', 'user_id');
    }

    public function coreValues() {
        return $this->hasMany('App\CompanyCoreValue', 'user_id');
    }

    public function companyWhyUs() {
        return $this->hasOne('App\CompanyWhyUs', 'user_id');
    }

    public function jobs() {
        return $this->hasMany('App\Job', 'user_id');
    }

    public function resumes() {
        return $this->hasMany('App\Resume', 'user_id');
    }

    public function jobApplications() {
        return $this->belongsToMany('App\Job', 'job_application');
    }

    public function phoneNumbers() {
        return $this->hasMany('App\PhoneNumber', 'user_id');
    }

    public function jobSeekerDetail() {
        return $this->hasOne('App\User', 'user_id');
    }
}
