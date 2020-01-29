<?php

namespace App\Http\Controllers\Api\Employer;

use App\User;
use App\CompanyCoreValues;
use App\CompanyWhyUs;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WhyUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::findOrFail($id);

        $companyWhyUs = $user->companyWhyUs;
        $coreValues = $user->coreValues;

        return response()->json([
            'tagline' => $companyWhyUs->tagline,
            'ethos' => $companyWhyUs->ethos,
            'coreValues' => $coreValues
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
        $request->validate([
            'tagline' => 'required',
            'ethos' => 'required',
            'coreValues' => 'required'
        ]);

        $user = User::findOrFail(auth()->id());

        // delete any previous data
        $user->coreValues()->delete();
        $user->companyWhyUs()->delete();

        // create new ones
        $companyWhyUs = new CompanyWhyUs();
        $companyWhyUs->tagline = $request->input('tagline');
        $companyWhyUs->ethos = $request->input('ethos');
        $companyWhyUs->user_id = $user->id;
        $companyWhyUs->save();

        $coreValues = $request->input('coreValues');
        $coreValuesToStore = [];
        foreach ($coreValues as $key => $coreValue) {
            $newCoreValue = [];
            $newCoreValue['user_id'] = $user->id;
            $newCoreValue['title'] = $coreValue['title'];
            $newCoreValue['subtitle'] = $coreValue['subtitle'];
            $newCoreValue['description'] = $coreValue['description'];
            array_push($coreValuesToStore, $newCoreValue);
        }
        DB::table('company_core_values')->insert($coreValuesToStore);

        if ($user->current_profile_creation_step < 4) {
            $user->current_profile_creation_step = 4;

            $user->save();
        }

        return response()->json([
            'tagline' => $companyWhyUs->tagline,
            'ethos' => $companyWhyUs->ethos,
            'coreValues' => $coreValuesToStore
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
