<?php

namespace App\Http\Controllers\Api\Jobs;

use App\Job;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobsRenewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Number $id
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $id)
    {
        $job = Job::findOrFail($id);

        if ($job->user_id !== auth()->id()) return response()->json([
            'status' => 'unauthorized'
        ]);

        $job->is_unexpired = 1;

        $job->save();

        return response()->json([
            'status' => 'success'
        ]);
    }
}
