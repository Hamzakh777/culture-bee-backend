<?php

namespace App\Http\Controllers\Api\Jobs;

use App\Job;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;

class JobsPublishController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        try {
            $user = Auth::user();
            $paymentMethod = $request->input('paymentMethod');
            // return url to handle 3D secure payment
            $payment = $user->charge(25000, $paymentMethod, [
                'return_url' => 'https://localhost:8081/job-post'
            ]);
    
            // set the job as paid
            // $job = Job::where('id', $id)->get();

            // $job->is_paid = true;

            // $job->save();
    
            return response()->json([
                'status' => 'success'
            ]);
        } catch (IncompletePayment $e) {
            return response()->json([
                'next_action' => $e->payment->next_action
            ]);
        }
    }
}
