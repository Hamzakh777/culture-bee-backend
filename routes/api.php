<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Auth::routes();

Route::post('newsletter', 'Api\Newsletter\NewsletterController@store');

Route::middleware('auth:api')->group(function () {
    // jobs
    // Route::get('jobs', 'Api\Jobs\JobsController@index');
    // Route::post('jobs', 'Api\Jobs\JobsController@store');
    Route::post('logout', 'Api\AuthController@logout');
    // Route::post('jobs/{id}/publish', 'Api\Jobs\JobsPublishController');
});

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
