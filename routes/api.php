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

    //Messages & Connections In Vendors
    Route::get('/connections/{status}/{id}','MessagesController@get_connections');
    Route::get('/messages/{connection_id}','MessagesController@messages');
    Route::post('/messages','MessagesController@add_new_message');
    Route::get('/messages/status/{to}/{from}/{connection_id}','MessagesController@viewed_status_update');
    Route::patch('/connection/status/{id}','MessagesController@connection_update');
    Route::post('/connection/make','MessagesController@create_connection');

    //Categories
    Route::get('/categories', 'CategoryController@index');
    Route::post('/categories', 'CategoryController@insert');
    Route::put('/categories', 'CategoryController@update');
    Route::delete('/categories/{id}',"CategoryController@delete");

    //Requests For Exchange
    Route::post('/services/request', 'ExchangeController@exchange_request');
    Route::get('exchange/requests/{receiver_id}', 'ExchangeController@getRequests'); //receive requests
    Route::get('exchange/send/requests/{sender_id}', 'ExchangeController@getSendRequests');//send requests
    Route::put('exchange/requests/{id}', 'ExchangeController@rejectRequest');
    Route::delete('exchange/requests/{id}', 'ExchangeController@deleteRequest');
    Route::get('exchange/find/request/{id}', 'ExchangeController@findRequest'); //find request
    Route::get('exchange/requested/services/{id}', 'ExchangeController@view_requested_services');//View Requested Services
    Route::get('exchange/offer/services/{id}', 'ExchangeController@view_offer_services');//View Sender Offer Services
    Route::get('exchange/agreement', 'ExchangeController@view_agreement');//View Exchange Agreement
    Route::post('exchange/payment', 'ExchangeController@saveWork');

    //Works History And Payments
    Route::get('/works/{id}', "WorksController@index");
    Route::get('/works-payments/{id}', "WorksController@workData");
    Route::get('/going-works/{id}', "WorksController@getCompanies");
    Route::get('/going-works-services/{id}', "WorksController@getCompaniesServices");
    Route::get("/detail-service/tasks/{work_service_id}","WorksController@getServiceTasks");
    Route::post("/detail-service/tasks/{work_service_id}","WorksController@create_task");
    Route::put("/detail-service/tasks/update/{id}","WorksController@update_task_progress");
    Route::get("/detail-service/files/{work_service_id}","WorksController@getServiceFiles");
    Route::post("/detail-service/files/{work_service_id}","WorksController@upload_files");
    Route::delete("/detail-service/files/{id}","WorksController@delete_files");
});
