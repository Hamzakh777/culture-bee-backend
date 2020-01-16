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
    // Route::post('jobs/{id}/publish', 'Api\Jobs\JobsPublishController');
    
    // auth
    Route::post('logout', 'Api\AuthController@logout');

    // user
    Route::post('profile', 'Api\Profile\ProfileController@update');
    Route::get('profile', 'Api\Profile\ProfileController@index');

    // ***************** employer
    Route::post('/employer/values', 'Api\Employer\ValuesController@store');

    // update
    Route::post('/employer/updates', 'Api\Employer\UpdatesController@store');
    Route::delete('/employer/updates/{id}', 'Api\Employer\UpdatesController@destroy');
    Route::put('/employer/updates/{id}', 'Api\Employer\UpdatesController@update');
    Route::get('/employer/{id}/updates', 'Api\Employer\UpdatesController@index');

    // benefits
    Route::post('employer/benefits/collection', 'Api\Employer\BenefitsController@storeCollection');

    // vision
    Route::get('employer/{id}/vision', 'Api\Employer\UpdatesController@index');
    Route::post('employer/vision', 'Api\Employer\UpdatesController@store');
    Route::put('employer/vision/{id}', 'Api\Employer\UpdatesController@update');
    
});

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');
