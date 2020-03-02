<?php

namespace App\Http\Controllers\Api\Feed;

use App\CompanyUpdate;
use App\Http\Resources\CompanyUpdate as CompanyUpdateResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        $followings = $user->followings()->pluck('id')->toArray();

        $updates = CompanyUpdate::whereIn('user_id', $followings)->paginate(20);

        return response()->json([
            'updates' => CompanyUpdateResource::collection($updates),
            'paginationData' => $updates
        ]);
    }
}
