<?php

namespace App\Http\Controllers\Api\Employer;

use App\User;
use App\Http\Resources\Users;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($id)
    {
        $user = User::findOrFail($id);

        return new Users($user);
    }
}
