<?php

namespace App\Http\Controllers\Api\Employer;

use App\User;
use App\CompanyVision;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $vision = User::find($id)->companyVision;

        return response()->json([
            'vision' => $vision
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required'
        ]);

        $vision = new CompanyVision();

        $vision->description = $request->input('description');
        $vision->user_id = auth()->id();

        $vision->save();

        // if its the first time the user is creating benefits
        // we increment his profile creation step
        $user = User::find(auth()->id());

        if ($user->current_profile_creation_step < 3) {
            $user->current_profile_creation_step = 3;

            $user->save();
        }

        return [
            'vision' => $vision
        ];
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
        $request->validate([
            'description' => 'required'
        ]);

        $vision = CompanyVision::find($id);

        $vision->description = $request->input('description');

        $vision->save();

        return [
            'success' => true
        ];
    }
}
