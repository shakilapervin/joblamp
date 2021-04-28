<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('register', 'Api\ApiController@registerUser');
Route::post('login', 'Api\ApiController@loginUser');
Route::get('countrylist', 'Api\ApiController@countryList');
Route::post('statelist', 'Api\ApiController@stateList');
Route::post('citylist', 'Api\ApiController@cityList');
Route::get('categorylist', 'Api\ApiController@categoryList');
Route::post('profile', 'Api\ApiController@profile');
Route::post('edit-profile', 'Api\ApiController@editProfile');
Route::post('update-docs', 'Api\ApiController@updateDocs');
Route::post('job-applications', 'Api\ApiController@jobApplications');
Route::post('review-list', 'Api\ApiController@reviewList');
Route::post('job-details', 'Api\ApiController@jobDetails');
Route::post('post-job', 'Api\ApiController@postJob');
Route::post('forgot-password', 'Api\ApiController@forgotPassword');
Route::post('check-reset-code', 'Api\ApiController@checkResetCode');
Route::post('change-password', 'Api\ApiController@changePassword');
Route::post('update-password', 'Api\ApiController@updatePassword');
Route::post('customer-joblist', 'Api\ApiController@customerJobList');
Route::post('worker-joblist', 'Api\ApiController@workerJobList');
Route::post('apply-job', 'Api\ApiController@applyJob');
Route::post('submit-job', 'Api\ApiController@submitJob');
Route::post('rate-user', 'Api\ApiController@rateUser');
Route::post('search', 'Api\ApiController@search');
Route::post('filter-job', 'Api\ApiController@filterJob');
Route::get('banner-list', 'Api\ApiController@bannerList');
Route::post('notification-list', 'Api\ApiController@notificationList');
Route::post('job-count', 'Api\ApiController@jobCount');
Route::get('top-rated-workers', 'Api\ApiController@topRatedWorkers');
Route::post('all-jobs', 'Api\ApiController@allJobList');
Route::post('chat-list', 'Api\ApiController@chatList');
Route::post('save-chat-file', 'Api\ApiController@saveChatFile');
Route::post('get-category-jobs', 'Api\ApiController@categoryJobList');
