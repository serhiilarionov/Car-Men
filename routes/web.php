<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Route::group([], function () {

    // Login Routes
    Route::get('login',
        ['as' => 'auth.login', 'uses' => '\Modules\Auth\Http\Controllers\LoginController@showLoginForm']);
    Route::post('login', ['as' => 'auth.login', 'uses' => '\Modules\Auth\Http\Controllers\LoginController@login']);
    Route::any('logout', ['as' => 'auth.logout', 'uses' => '\Modules\Auth\Http\Controllers\LoginController@logout']);

    // Registration Routes
    Route::get('register',
        ['as' => 'auth.register', 'uses' => '\Modules\Auth\Http\Controllers\RegisterController@showRegistrationForm']);
    Route::post('register',
        ['as' => 'auth.register', 'uses' => '\Modules\Auth\Http\Controllers\RegisterController@register']);

    // Password Reset Routes
    Route::post('password/email', [
        'as' => 'auth.password.email',
        'uses' => '\Modules\Auth\Http\Controllers\ForgotPasswordController@sendResetLinkEmail'
    ]);
    Route::get('password/reset', [
        'as' => 'auth.password.email',
        'uses' => '\Modules\Auth\Http\Controllers\ForgotPasswordController@showLinkRequestForm'
    ]);
    Route::post('password/reset',
        ['as' => 'auth.password.reset', 'uses' => '\Modules\Auth\Http\Controllers\ResetPasswordController@reset']);
    Route::get('password/reset/{token?}', [
        'as' => 'auth.password.reset',
        'uses' => '\Modules\Auth\Http\Controllers\ResetPasswordController@showResetForm'
    ]);
});

Route::get('/google/authorize', [
    'as' => 'google.authorize',
    'uses' => '\Modules\Auth\Http\Controllers\GoogleController@googleAuthorize'
]);

Route::get('/google/login', [
    'as' => 'google.login',
    'uses' => '\Modules\Auth\Http\Controllers\GoogleController@login'
]);


Route::get('/home', ['middleware' => [], 'uses' => 'HomeController@index']);
