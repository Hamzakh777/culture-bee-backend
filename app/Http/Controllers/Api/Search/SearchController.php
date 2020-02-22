<?php

namespace App\Http\Controllers\Api\Search;

use App\User;
use App\Job;
use App\CompanyUpdate;
use App\Http\Resources\Users as UsersResource;
use App\Http\Resources\CompanyUpdate as CompanyUpdateResource;
use App\Http\Resources\Job as JobResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'category' => 'required'
        ]);

        $results = [];
        $category = $request->input('category');
        $query = $request->input('query');

        if($category === 'employers') {
            $employers = User::search($query . ' employer')->paginate(20);

            $results =  UsersResource::collection($employers);
        } else if ($category === 'updates') {
            $updates = CompanyUpdate::search($query)->paginate(20);

            $results = CompanyUpdateResource::collection($updates);
        } else if ($category === 'jobs') {
            $jobs = Job::search($query)
                ->where('is_unexpired', 1)    
                ->paginate(20);

            $results = JobResource::collection($jobs);
        }

        return response()->json([
            'results' => $results
        ]);
    }
}
