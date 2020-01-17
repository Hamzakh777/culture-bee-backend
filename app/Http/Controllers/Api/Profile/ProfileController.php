<?php

namespace App\Http\Controllers\Api\Profile;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Resources\Users;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() {
        return new Users(Auth::user());
    }

    public function update(Request $request) {
        $user = User::find(auth()->id());

        $user->name = $request->input('name');

        if ($request->hasFile('profileImgFile')) {
            $path  = $request->file('profileImgFile')->store(
                'users/profile-img',
                'do_spaces'
            );
            // we should delete old files if they exist
            $user->profile_img_url = Storage::disk('do_spaces')->url($path);
        }

        if ($request->hasFile('coverImgFile')) {
            $path  = $request->file('coverImgFile')->store(
                'users/cover-img',
                'do_spaces'
            );
            // we should delete old files if they exist
            $user->cover_img_url = Storage::disk('do_spaces')->url($path);
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

        if ($request->has('quickPitch')) {
            $user->quick_pitch = $request->input('quick_pitch');
        }

        $user->save();

        return response()->json([
            'userId' => $user->id,
            'user' => new Users($user)
        ]);
    }   
}
