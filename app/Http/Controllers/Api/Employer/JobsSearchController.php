<?php

namespace App\Http\Controllers\Api\Employer;

use App\Job;
use App\Http\Resources\Job as JobResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobsSearchController extends Controller
{
    /**
     * Turn a nullisht value to an empty string
     * @param mixed $value 
     * @return string|void 
     */
    protected function nullToString($value)
    {
        if ($value === null) {
            return '';
        }
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $query = $this->nullToString($request->input('query'));
        $location = $this->nullToString($request->input('location'));
        $seniority = $this->nullToString($request->input('seniority'));
        $industry = $this->nullToString($request->input('industry'));
        $type = $this->nullToString($request->input('type'));
        $category = $request->input('category'); // either live or expired

        // still need to include the id of the current logged in user
        // and also add logic to know if the job has expired or not yet
        $jobs = Job::search($query . $location . $seniority . $industry)
            ->where('is_unexpired', $category === 'live' ? 1 : 0)
            ->paginate(15);

        return response()->json([
            'jobs' => JobResource::collection($jobs),
            'query' => $query
        ]);
    }
}
