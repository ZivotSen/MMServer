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

// Unauthorized route
Route::match(['get', 'post'], '/unauthorized', array(
    'before' => 'csrf',
    'as' => 'unauthorized',
    'uses' => '\App\Http\Controllers\LoginController@unauthorized'
));

Route::match(['post'], '/login', array(
    'before' => 'csrf',
    'as' => 'login',
    'uses' => '\App\Http\Controllers\LoginController@login'
));

Route::match(['post'], '/register', array(
    'before' => 'csrf',
    'as' => 'register',
    'uses' => '\App\Http\Controllers\RegisterController@register'
));

Route::match(['post'], '/update', array(
    'before' => 'csrf',
    'as' => 'update',
    'uses' => '\App\Http\Controllers\RegisterController@update'
))->middleware('auth:api');

// Basic Logout route
Route::match(['get', 'post'], '/logout', array(
    'before' => 'csrf',
    'as' => 'logout',
    'uses' => '\App\Http\Controllers\LoginController@logout'
))->middleware('auth:api');
