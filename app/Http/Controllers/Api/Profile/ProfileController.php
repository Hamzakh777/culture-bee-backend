<?php

namespace App\Http\Controllers\Api\Profile;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function update(Request $request) {
        $user = Auth::user();

        $user->name = $request->input('name');
        
        if($request->hasFile('profileImgFile')) {
            $user->profile_img_url = $request->file('profileImgFile')->store(
                'users/profile-img',
                'do_spaces'
            );
        }

        $user->save();

        return response()->json([
            'user' => $user
        ]);
    }   
}
