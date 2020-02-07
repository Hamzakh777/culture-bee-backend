<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string']
        ]);
    }

    protected function asignRole(User $user, Request $request)
    {
        $role = $request->input('role');

        $user->assignRole($role);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request)
    {
        return $this->login($request);
    }

    public function login(Request $request) {
        // Requesting Tokens
        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => 1,
            'client_secret' => '4Jo09TrMQBHsyOzZjmyyxHCUCBumG3AQ86xYEozi',
            'username'      => $request->input('email'),
            'password'      => $request->input('password'),
            'scope'         => '',
        ]);


        // Fire off the internal request. 
        $token = Request::create(
            'oauth/token',
            'POST'
        );

        return \Route::dispatch($token);
    }

    public function register(Request $request) {
        $valid = $this->validator($request->all());


        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);
            return response()->json($jsonError);
        }

        // create a new user
        $data = request()->only('email', 'password');

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        event(new Registered($user));

        // asign a role to the user
        $this->asignRole($user, $request);

        return $this->registered($request);
    } 

    public function logout(Request $request) {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);
    }
}
