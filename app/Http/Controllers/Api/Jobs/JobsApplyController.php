<?php

namespace App\Http\Controllers\Api\Jobs;

use App\Resume;
use App\Mail\AppliedToJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Job;
use Illuminate\Http\Request;

class JobsApplyController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        $user = auth()->user();

        $resume = new Resume();
        $resume->user_id = $user->id;

        // store the cv
        if ($request->hasFile('cv')) {
            $path  = $request->file('cv')->store(
                'resumes/',
                'do_spaces'
            );

            $resume->resume_url = Storage::disk('do_spaces')->url($path);
        }

        $resume->resume_url = 'test';

        $resume->save();

        // send the email
        Mail::to('test@test.test')->send(new AppliedToJob($user->id));

        // store the application
        $job->applications()->attach($user->id);

        return response()->json([
            'tets' => true
        ]);
    }
}
