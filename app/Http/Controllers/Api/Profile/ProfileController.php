<?php

namespace App\Http\Controllers\Api\Profile;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Users;

class ProfileController extends Controller
{
    public function index() {
        return new Users(Auth::user());
    }

    public function update(Request $request) {
        $user = Auth::user();

        $user->name = $request->input('name');
        
        if($request->hasFile('profileImgFile')) {
            $user->profile_img_url = $request->file('profileImgFile')->store(
                'users/profile-img',
                'do_spaces'
            );
        }

        if ($request->has('location')) {
            $user->location = $request->input('location');
        }

        if ($request->has('companyName')) {
            $user->company_name = $request->input('companyName');
        }

        if ($request->has('industry')) {
            $user->industry = $request->input('industry');
        }

        if ($request->has('skills')) {
            $user->skills = json_encode($request->input('skills'));
        }

        $user->save();

        return response()->json([
            'userId' => $user->id,
            'request' => $request->input('location')
        ]);
    }   
}
