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
Route::group([
    'middleware' => 'auth:api'
], function(){
    Route::post('details', 'API\UserController@details');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'namespace' => 'API\v1',
    'prefix' => 'v1',
], function () {

    $this->group([ 'namespace' => 'Blog' ], function () {

        Route::resource('/article', 'ArticleController');
    });

    $this->group([ 'namespace' => 'Product' ], function () {

        Route::resource('/product', 'ProductController');
    });

    $this->group([ 'namespace' => 'Opinion' ], function () {

        Route::put('/comment/accept/{comment}', 'CommentController@accept');
        Route::resource('/comment', 'CommentController');

        Route::put('/review/accept/{review}', 'ReviewController@accept');
        Route::resource('/review', 'ReviewController');
        
        Route::put('/question_and_answer/accept/{question_and_answer}', 'QuestionAndAnswerController@accept');
        Route::resource('/question_and_answer', 'QuestionAndAnswerController');
    });
    
    $this->group([ 'namespace' => 'Financial' ], function () {

        Route::resource('/shipping_method', 'ShippingMethodContrller');
        Route::resource('/order_status', 'OrderStatusContrller');

        $this->post('/order/{order}/add/{variation}/{quantity?}', 'OrderController@add');
        $this->delete('/order/{order}/remove/{variation}', 'OrderController@remove');
        $this->put('/order/description/{order}', 'OrderController@description');
        $this->put('/order/status/{order}/{status}', 'OrderController@status');
        Route::resource('/order', 'OrderController');
    });
    
    $this->group([ 'namespace' => 'Group' ], function () {

        Route::resource('/category', 'CategoryController');
        Route::resource('/subject', 'SubjectController');
    });

    $this->group([ 'namespace' => 'Feature' ], function () {

        Route::resource('/brand', 'BrandController');
        Route::resource('/color', 'ColorController');
        Route::resource('/size', 'SizeController');
        Route::resource('/warranty', 'WarrantyController');
        Route::resource('/unit', 'UnitController');
    });

    $this->group([ 'namespace' => 'Spec' ], function () {

        Route::resource('/spec', 'SpecController');
        Route::post('/spec_header/copy/{spec_header}', 'SpecHeaderController@copy');
        Route::resource('/spec_header', 'SpecHeaderController')->only('store', 'update', 'destroy');
        Route::resource('/spec_row', 'SpecRowController')->only('store', 'update', 'destroy');
        
        // Route::resource('/spec_data', 'SpecDataController');
    });
});