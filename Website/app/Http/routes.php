<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Authentication Routes
Route::auth();
Route::any('/register', function() {
    abort(404);
});
Route::any('/password/reset', function() {
    abort(404);
});

// Routes for client pages
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'MainController@index');
    
    Route::get('/auth_success', 'MainController@success');

    // Routes for Administrator pages
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/admin', function () {
            return "hello admin";
        });
    });
});