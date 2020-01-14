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
        $user = User::find($id);

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
        $user = auth()->user();

        $request->validate([
            'values' => 'required',
        ]);

        // delete any previous values for the authenticated user 
        $user->values()->delete();

        // create new ones
        $values = $request->input('values');
        
        $updatedValues = [];
        foreach ($values as $key => $value) {
            $value['user_id'] = $user->id;

            array_push($updatedValues, $value);
        }

        DB::table('company_values')->insert($updatedValues);

        return [
            'success' => true
        ];
    }
}
