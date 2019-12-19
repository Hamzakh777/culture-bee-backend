<?php

namespace App\Http\Controllers\Newsletter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Newsletter;

class NewsletterController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'email' => 'required|email'
        ]);

        Newsletter::subscribe($request->input('email'));

        return response()->json([
            'success' => true
        ]);
    }
}
