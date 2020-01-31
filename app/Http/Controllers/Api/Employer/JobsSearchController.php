<?php

namespace App\Http\Controllers\Api\Employer;

use App\Job;
use App\Http\Resources\Job as JobResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobsSearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // we get the category - either live or expired
        $query = $request->input('query');

        $jobs = Job::search()->get();

        return response()->json([
            'jobs' => JobResource::collection($jobs)
        ]);
    }
}
