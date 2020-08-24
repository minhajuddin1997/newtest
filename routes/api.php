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
    //Vendors list
    Route::get('/user/{id}', 'ProfileController@view');
    Route::post('/user', 'ProfileController@insert');
    Route::put('/user/update', 'ProfileController@update');
    Route::put('/user/info/update/{id}', 'ProfileController@updateCompanyInfo');
    Route::put('/user/status/update/{id}', 'ProfileController@updateProfileStatus');
    Route::delete('/user/{id}', 'ProfileController@delete');
    Route::get('/vendors', 'ProfileController@index');

    //Services In Vendors Dashboard
    Route::get('/services/{user_id}', 'ServiceController@index');
    Route::post('/services', 'ServiceController@insert');
    Route::put('/services', 'ServiceController@update');
    Route::delete('/services/{id}',"ServiceController@delete");
    Route::get('/company/search/{id}/{text}',"DashboardController@search_service_company");
    Route::get('/services/search_logs/{id}',"DashboardController@search_logs");
    Route::get('/services/search/{id}',"DashboardController@search_services");

    //Categories
    Route::get('/categories', 'CategoryController@index');
    Route::post('/categories', 'CategoryController@insert');
    Route::put('/categories', 'CategoryController@update');
    Route::delete('/categories/{id}',"CategoryController@delete");

});
