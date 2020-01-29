<?php

namespace App\Http\Controllers\Api\Employer;

use App\User;
use App\Http\Resources\Job as JobResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $jobs = User::findOrFail($id)->jobs;

        return response()->json([
            'jobs' => JobResource::collection($jobs)
        ]);
    }
}
