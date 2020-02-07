<?php

namespace App\Http\Controllers\Api\Employer;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::findOrFail($id);

        return response()->json([
            'values' => $user->values
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find(auth()->id());


        // delete any previous values for the authenticated user 
        $user->values()->delete();

        // create new ones
        $values = $request->input('values');
        
        $updatedValues = [];
        foreach ($values as $key => $value) {
            $newValue = [];
            
            $newValue['user_id'] = $user->id;
            $newValue['title'] = $value['title'];
            $newValue['icon'] = $value['icon'];

            array_push($updatedValues, $newValue);
        }

        DB::table('company_values')->insert($updatedValues);

        // if its the first time the user is creating values
        // we increment his profile creation step
        if($user->current_profile_creation_step === 0) {
            $user->current_profile_creation_step = 1;

            $user->save();
        }

        return [
            'success' => true,
            'values' => $values
        ];
    }
}
