<?php

namespace App\Http\Controllers\Api\Employer;

use App\User;
use App\CompanyBenefit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CompanyBenefitResource as CompanyBenefitResource;

class BenefitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $benefits = User::findOrFail($id)->benefits;

        return response()->json([
            'benefits' => CompanyBenefitResource::collection($benefits)
        ]);
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
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required'
        ]);

        $benefit = CompanyBenefit::find($id);

        $benefit->title = $request->input('title');
        $benefit->subtitle = $request->input('subtitle');

        if($request->input('imgUrl') !== $benefit->img_url) {
            $parsedUrl = parse_url($benefit->img_url);
            Storage::delete($parsedUrl['path']);

            $benefit->img_url = null;
        }

        if ($request->hasFile('imgFile')) {
            // if already has an image we delete it
            if ($benefit->img_url !== null) {
                $parsedUrl = parse_url($benefit->img_url);
                Storage::delete($parsedUrl['path']);
            }

            $path = Storage::disk('do_spaces')->putFile('companies/benefits', $request->file('imgFile'));

            $benefit->img_url = Storage::disk('do_spaces')->url($path);
        }


        $benefit->save();

        return response()->json([
            'benefit' => new CompanyBenefitResource($benefit)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $benefit = CompanyBenefit::findOrFail($id);

            if($benefit->img_url !== null) {
                $parsedUrl = parse_url($benefit->img_url);

                Storage::delete($parsedUrl['path']);
            }

            $benefit->delete();

            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ]);
        }
    }

    /**
     * Store more than 1 benefit at once
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeCollection(Request $request) {
        $user = User::find(auth()->id());

        $storedBenefits = [];
        for ($i=1; $i < 7; $i++) {
            $benefit = new CompanyBenefit();

            $benefit->title = $request->input('title' . $i);
            $benefit->subtitle = $request->input('subtitle' . $i);
            $benefit->user_id = $user->id;

            if ($request->hasFile('imgFile' . $i)) {
                $path = Storage::disk('do_spaces')->putFile('companies/benefits', $request->file('imgFile' . $i));

                $benefit->img_url = Storage::disk('do_spaces')->url($path);
            }

            $benefit->save();

            array_push($storedBenefits, $benefit);
        }

        // if its the first time the user is creating benefits
        // we increment his profile creation step
        if ($user->current_profile_creation_step < 5) {
            $user->current_profile_creation_step = 5;

            $user->save();
        }

        return response()->json([
            'benefits' => CompanyBenefitResource::collection($storedBenefits)
        ]);
    }
}
