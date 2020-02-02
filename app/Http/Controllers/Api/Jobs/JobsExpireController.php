<?php

namespace App\Http\Controllers\Api\Jobs;

use App\Http\Controllers\Controller;
use App\Job;
use Illuminate\Http\Request;

class JobsExpireController extends Controller
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

        if($job->user_id !== auth()->id()) return response()->json([
            'status' => 'unauthorized'
        ]);

        $job->is_unexpired = 0;

        $job->save();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
