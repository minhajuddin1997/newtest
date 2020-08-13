<?php

use Illuminate\Http\Request;

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

//'middleware' => 'api:auth'
Route::group(['namespace' => 'api\Auth'], function () {
    Route::post('/login','AuthController@login');
    Route::post('/logout','AuthController@logout');
    Route::post('/register','AuthController@register');
});

Route::group(['namespace' => 'api\admin','middleware' => 'auth:api' ], function () {
    Route::put('/user/update', 'ProfileController@update');
});
