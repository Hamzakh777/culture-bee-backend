<?php

namespace App\Http\Controllers\Api\Employer;

use App\User;
use App\CompanyUpdate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CompanyUpdate as CompanyUpdateResource;

class UpdatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $updates = User::find($id)->companyUpdates;

        return response()->json([
            'updates' => CompanyUpdateResource::collection($updates)
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
            'description' => 'required',
        ]);

        $update = new CompanyUpdate();

        $update->description = $request->input('description');
        $update->tags = $request->input('tags');
        $update->is_pinned = $request->input('isPinned');
        $update->user_id = auth()->id();

        if ($request->hasFile('imgFile')) {
            $path  = $request->file('imgFile')->store(
                'companies/updates',
                'do_spaces'
            );

            $update->img_url = Storage::disk('do_spaces')->url($path);
        }

        $update->save();

        return response()->json([
            'update' => new CompanyUpdateResource($update)
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
            'description' => 'required',
        ]);

        $update = CompanyUpdate::find($id);

        $update->description = $request->input('description');
        $update->tags = $request->input('tags');
        $update->is_pinned = $request->input('isPinned');
        $update->user_id = auth()->id();

        if ($request->hasFile('imgFile')) {
            // if already has an image we delete it
            if($update->img_url !== null) { 
                $parsedUrl = parse_url($update->img_url);

                Storage::delete($parsedUrl['path']);
            }

            $path  = $request->file('imgFile')->store(
                'companies/updates',
                'do_spaces'
            );

            $update->img_url = Storage::disk('do_spaces')->url($path);
        }

        if($request->input('imgUrl') !== $update->img_url) {
            $parsedUrl = parse_url($update->img_url);

            Storage::delete($parsedUrl['path']);
        }

        $update->save();

        return response()->json([
            'update' => new CompanyUpdateResource($update)
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
        CompanyUpdate::find($id)->delete();
        
        return response()->json([
            'success' => true
        ]);
    }
}
