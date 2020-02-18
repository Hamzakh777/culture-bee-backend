<?php

namespace App\Http\Controllers\Api\Newsletter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Newsletter;

class NewsletterController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email',
            'audienceType' => 'required'
        ]);

        Newsletter::subscribe($request->input('email'), ['AUDIENCE' => $request->input('audienceType')]);

        return response()->json([
            'success' => true
        ]);
    }
}
