<?php

namespace App\Http\Controllers\Api\Jobs;

use App\Job;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
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

        $job->company_pitch = $request->input('companyPitch');
        $job->job_title = $request->input('jobTitle');
        $job->job_story = $request->input('jobStory');
        $job->male_split = $request->input('maleSplit');
        $job->average_age = $request->input('averageAge');
        $job->working_hours = $request->input('workingHours');
        $job->finance_stage = $request->input('financeStage');
        $job->amount_raised = $request->input('amountRaised');
        $job->starting_salary = $request->input('startingSalary');
        $job->equity_bonus = $request->input('equityBonus');
        $job->headcount = $request->input('headcount');
        $job->year_founded = $request->input('yearFounded');
        $job->company_url = $request->input('companyurl');
        $job->start_date = $request->input('start_date');
        $job->location = $request->input('location');
        $job->linkedin_profile_url = $request->input('linkedinProfileUrl');
        $job->angelist_profile_url = $request->input('angelistProfileUrl');
        $job->crunchbase_profile_url = $request->input('crunchbaseProfileUrl');
        $job->application_email = $request->input('applicationEmail');
        $job->application_url = $request->input('applicationUrl');

        // storing json
        $job->communication_tools = json_encode($request->input('communicationTools'));
        $job->tags = json_encode($request->input('tags'));
        $job->company_achievements = json_encode($request->input('companyAchievements'));
        $job->interview_process = json_encode($request->input('interviewProcess'));
        $job->communication_tools = json_encode($request->input('communicationTools'));
        $job->tags = json_encode($request->input('tags'));
        $job->company_achievements = json_encode($request->input('companyAchievements'));
        $job->interview_process = json_encode($request->input('interviewProcess'));
        $job->required_skills = json_encode($request->input('requiredSkills'));
        $job->company_values = json_encode($request->input('company_values'));
        $job->atmosphere_characteristics = json_encode($request->input('atmosphereCharacteristics'));
        $job->perks = json_encode($request->input('perks'));


        if($request->hasFile('hiringManagersAudioFile')) {
            $job->hiring_managers_audio_url  = $request->file('hiringManagersAudioFile')->store(
                'companies/audio',
                'do_spaces'
            );
        }

        if ($request->hasFile('employerTeamOfficeImgFile')) {
            $job->hiring_managers_audio_url  = $request->file('employerTeamOfficeImgFile')->store(
                'companies/images/team_office',
                'do_spaces'
            );
        }

        if ($request->hasFile('employerLogoUrl')) {
            $job->hiring_managers_audio_url  = $request->file('employerLogoUrl')->store(
                'companies/images/logo',
                'do_spaces'
            );
        }


        $job->user_id = Auth::id();

        $job->save();

        return response()->json([
            'status' => 'success',
            'job' => $job
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
        $job = Job::where('id', $id)->get();
        
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
