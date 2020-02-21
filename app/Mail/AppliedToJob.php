<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppliedToJob extends Mailable
{
    use Queueable, SerializesModels;

    
    protected $jobseekerProfile;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->jobSeekerProfile = env('APP_FRONT_END_URL', 'http://localhost') . '/jobseeker/' . $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(`You've got an application!`)
            ->markdown('emails.jobs.apply', [
                'jobSeekerProfile' => $this->jobSeekerProfile
            ]);
    }
}
