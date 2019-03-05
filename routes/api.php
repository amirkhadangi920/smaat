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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', 'API\UserController@details');
});

Route::group([
    'namespace' => 'API\v1',
    'prefix' => 'v1',
    'middleware' => 'auth:api'
], function () {

    Route::resource('/articles', 'ArticleController');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});