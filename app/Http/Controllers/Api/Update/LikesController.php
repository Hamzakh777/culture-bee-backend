<?php

namespace App\Http\Controllers\Api\Update;

use App\CompanyUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LikesController extends Controller
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
        $user = auth()->user();
        $update = CompanyUpdate::where('id', $id)->first();

        $liked = $user->hasLiked($update);
        
        if ($liked) {
            $user->unlike($update);
        } else {
            $user->like($update);
        }

        return response()->json([
            'isLiked' =>  $user->hasLiked($update)
        ]);
    }
}
