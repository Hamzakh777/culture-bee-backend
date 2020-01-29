<?php

namespace App\Http\Controllers\Api\Jobs;

use App\Job;
use App\User;
use App\Http\Resources\Job as JobResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $job = new Job;

        $job->job_title = $request->input('jobTitle');
        $job->quick_pitch = $request->input('quickPitch');
        $job->location = $request->input('location');
        $job->industry = $request->input('industry');
        $job->seniority = $request->input('seniority');
        $job->type = $request->input('type');
        $job->application_email = $request->input('applicationEmail');
        $job->application_url = $request->input('applicationUrl');
        $job->about_the_colleagues = $request->input('aboutTheColleagues');
        $job->why_this_role = $request->input('whyThisRole');

        // storing json
        $job->skills = $request->input('skills');
        $job->tags = $request->input('tags');
        $job->ownership_values = $request->input('ownershipValues');
        $job->applicant_qualities = $request->input('applicantQualities');

        // storing files
        if ($request->hasFile('promoPhoto')) {
            $path  = $request->file('promoPhoto')->store(
                'companies/jobs/promo_photo',
                'do_spaces'
            );

            $job->promo_photo_url = Storage::disk('do_spaces')->url($path);
        }

        if ($request->hasFile('familyPhoto')) {
            $path  = $request->file('familyPhoto')->store(
                'companies/jobs/family_photos',
                'do_spaces'
            );

            $job->family_photo_url = Storage::disk('do_spaces')->url($path);
        }

        $job->user_id = auth()->id();

        $job->save();

        $user = User::find(auth()->id());
        if ($user->current_profile_creation_step < 6) {
            $user->current_profile_creation_step = 6;

            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'job' => new JobResource($job)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = Job::where('id', $id)->first();

        return response()->json([
            'job' => new JobResource($job)
        ]);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
