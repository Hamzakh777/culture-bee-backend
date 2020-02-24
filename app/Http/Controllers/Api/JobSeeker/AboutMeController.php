<?php

namespace App\Http\Controllers\Api\JobSeeker;

use App\JobSeekerDetail;
use App\PhoneNumber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutMeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'aboutMe' => 'required'
        ]);

        $user = auth()->user();

        $jobSeekerDetail = new JobSeekerDetail();

        $jobSeekerDetail->about_me = $request->input('aboutMe');
        $jobSeekerDetail->user_id = $user->id;

        $jobSeekerDetail->save();

        $phoneNumber = '';
        if($request->input('phoneNumber') !== null) {
            $phoneNumber = new PhoneNumber();

            $phoneNumber->phone_number = $request->input('phoneNumber');
            $phoneNumber->user_id = $user->id;

            $phoneNumber->save();
        }

        return response()->json([
            'status' => 'success',
            'aboutMe' => $jobSeekerDetail->about_me,
            'phoneNumber' => $phoneNumber
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
        return response()->json([
            'aboutMe' => 'test',
            'phoneNumber' => 'adfasdf'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'aboutMe' => 'required'
        ]);

        $userId = auth()->id();

        $jobSeekerDetail = JobSeekerDetail::where('user_id', $userId)->first();

        $jobSeekerDetail->about_me = $request->input('aboutMe');

        $jobSeekerDetail->save();

        $phoneNumber = '';
        if ($request->input('phoneNumber') !== null) {
            $phoneNumber = new PhoneNumber();

            $phoneNumber->phone_number = $request->input('phoneNumber');
            $phoneNumber->user_id = $userId;

            $phoneNumber->save();
        } else if (PhoneNumber::where('user_id', $userId)->first() !== null) {
            $phoneNumber = PhoneNumber::where('user_id', $userId)->first();

            $phoneNumber->phone_number = $request->input('phoneNumber');

            $phoneNumber->save();
        }

        return response()->json([
            'status' => 'success',
            'aboutMe' => $jobSeekerDetail->about_me,
            'phoneNumber' => $phoneNumber->phone_number
        ]);
    }
}
