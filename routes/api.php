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

// search 
Route::post('search', 'Api\Search\SearchController');

Route::middleware('auth:api')->group(function () {
    // jobs
    // Route::get('jobs', 'Api\Jobs\JobsController@index');
    Route::post('jobs', 'Api\Jobs\JobsController@store');
    Route::put('jobs/{id}', 'Api\Jobs\JobsController@update');
    Route::delete('jobs/{id}', 'Api\Jobs\JobsController@destroy');
    Route::post('jobs/{id}/expire', 'Api\Jobs\JobsExpireController');
    Route::post('jobs/{id}/renew', 'Api\Jobs\JobsRenewController');
    Route::post('jobs/{id}/apply', 'Api\Jobs\JobsApplyController');
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

    // benefits
    Route::post('employer/benefits/collection', 'Api\Employer\BenefitsController@storeCollection');
    Route::post('employer/benefits', 'Api\Employer\BenefitsController@store');
    Route::put('employer/benefits/{id}', 'Api\Employer\BenefitsController@update');
    Route::delete('/employer/benefits/{id}', 'Api\Employer\BenefitsController@destroy');

    // employer jobs
    Route::post('employer/jobs/search', 'Api\Employer\JobsSearchController');

    // vision
    Route::post('employer/vision', 'Api\Employer\VisionController@store');
    Route::put('employer/vision/{id}', 'Api\Employer\VisionController@update');

    // why us
    Route::post('employer/why-us', 'Api\Employer\WhyUsController@store');

    // following 
    Route::post('user/{id}/follow', 'Api\User\FollowController');
    Route::post('user/{id}/unfollow', 'Api\User\UnfollowController');

    // job seeker 
    Route::post('job-seeker/about-me', 'Api\JobSeeker\AboutMeController@store');
    Route::put('job-seeker/about-me', 'Api\JobSeeker\AboutMeController@update');
});

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

// ************** employer
Route::get('/employer/{id}', 'Api\Employer\ProfileController@index');

// values
Route::get('/employer/{id}/values', 'Api\Employer\ValuesController@index');

// benefits
Route::get('/employer/{id}/benefits', 'Api\Employer\BenefitsController@index');

// why us
Route::get('employer/{id}/why-us', 'Api\Employer\WhyUsController@index');

// update 
Route::get('/employer/{id}/updates', 'Api\Employer\UpdatesController@index');

// vision 
Route::get('employer/{id}/vision', 'Api\Employer\VisionController@index');

// jobs
Route::get('employer/{id}/jobs', 'Api\Employer\JobsController');

// jobs
Route::get('jobs/{id}', 'Api\Jobs\JobsController@show');

/** 
 * Job seeker
*/
Route::get('job-seeker/about-me', 'Api\JobSeeker\AboutMeController@show');