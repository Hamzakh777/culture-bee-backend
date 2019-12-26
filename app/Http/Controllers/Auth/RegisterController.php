<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Laravel\Passport\Client as PassportClient;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string']
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {

        $client = PassportClient::where('password_client', 1)->first();

        // Requesting Tokens
        $request->request->add([
            'grant_type'    => 'password',
            'client_id'     => 8,
            'client_secret' => 'GRof8KUc8nN8uUzfnxl7Z79HAOtWbQ8W7nmW4BVU',
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

    public function asignRole(User $user, Request $request) {
        $role = $request->input('role');

        $user->assignRole($role);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $valid = $this->validator($request->all());

        $valid = $this->validator($request->all());

        if ($valid->fails()) {
            $jsonError = response()->json($valid->errors()->all(), 400);
            return response()->json($jsonError);
        }

        // create a new user
        $data = request()->only('email', 'name', 'password');

        $user = $this->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        event(new Registered($user));

        // asign a role to the user
        $this->asignRole($user, $request);

        return $this->registered($request, $user);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
