<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Opening routes
Route::get ('/job-openings',        'JobOpenings@getJobOpenings');
Route::get ('/job-openings/list',   'JobOpenings@listJobOpenings');
Route::post('/job-openings/save',   'JobOpenings@saveJobOpening');
Route::post('/job-openings/delete', 'JobOpenings@deleteJobOpening');

// Applicant routes
Route::get ('/applicants',        'Applicants@getApplicants');
Route::get ('/applicants/list',   'Applicants@listApplicants');
Route::post('/applicants/save',   'Applicants@saveApplicant');
Route::post('/applicants/delete', 'Applicants@deleteApplicant');

