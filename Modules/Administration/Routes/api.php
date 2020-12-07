<?php

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

/* ADMINISTRATION ROUTES */
Route::middleware('auth:api')->prefix('administration')->group(function() {
    /* USER ROUTES */
    Route::middleware('auth:api')->prefix('user')->group(function() {
        Route::match(['get', 'post'], '/', array(
            'before' => 'csrf',
            'as' => 'administration_user',
            'uses' => 'UserController@index'
        ))->middleware('grant:ROLE_USER_READ');
        Route::match(['post'], '/create/', array(
            'before' => 'csrf',
            'as' => 'administration_user_create',
            'uses' => 'UserController@store'
        ))->middleware('grant:ROLE_USER_CREATE');
        Route::match(['get', 'post'], '/show/{id}/', array(
            'before' => 'csrf',
            'as' => 'administration_user_read',
            'uses' => 'UserController@show'
        ))->middleware('grant:ROLE_USER_READ');
        Route::match(['put'], '/update/{id}/', array(
            'before' => 'csrf',
            'as' => 'administration_user_update',
            'uses' => 'UserController@update'
        ))->middleware('grant:ROLE_USER');
        Route::match(['delete'], '/delete/{id}/', array(
            'before' => 'csrf',
            'as' => 'administration_user_delete',
            'uses' => 'UserController@delete'
        ))->middleware('grant:ROLE_USER_DELETE');
    });
});
