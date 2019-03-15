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

$this->post('login', 'API\UserController@login');
$this->post('register', 'API\UserController@register');
$this->group([
    'middleware' => 'auth:api'
], function(){
    $this->post('details', 'API\UserController@details');
});
$this->middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'namespace' => 'API\v1',
    'prefix' => 'v1',
], function () {

    $this->get('/location/provinces/{country}', 'LocationController@provinces');
    $this->get('/location/provinces/{province}/cities', 'LocationController@cities');

    $this->group([ 'namespace' => 'Blog' ], function () {

        $this->get('/article/{article}/like', 'ArticleController@like');
        $this->get('/article/{article}/dislike', 'ArticleController@dislike');
        $this->resource('/article', 'ArticleController');
    });

    $this->group([ 'namespace' => 'Product' ], function () {

        $this->get('/product/{product}/like', 'ProductController@like');
        $this->get('/product/{product}/dislike', 'ProductController@dislike');
        $this->resource('/product', 'ProductController');
    });

    $this->group([ 'namespace' => 'Opinion' ], function () {

        $this->get('/comment/{comment}/like', 'CommentController@like');
        $this->get('/comment/{comment}/dislike', 'CommentController@dislike');
        $this->put('/comment/accept/{comment}', 'CommentController@accept');
        $this->resource('/comment', 'CommentController');

        $this->get('/review/{review}/like', 'ReviewController@like');
        $this->get('/review/{review}/dislike', 'ReviewController@dislike');
        $this->put('/review/accept/{review}', 'ReviewController@accept');
        $this->resource('/review', 'ReviewController');
        
        $this->put('/question_and_answer/accept/{question_and_answer}', 'QuestionAndAnswerController@accept');
        $this->resource('/question_and_answer', 'QuestionAndAnswerController');
    });
    
    $this->group([ 'namespace' => 'Financial' ], function () {

        $this->resource('/shipping_method', 'ShippingMethodContrller');
        $this->resource('/order_status', 'OrderStatusContrller');

        $this->post('/order/{order}/add/{variation}/{quantity?}', 'OrderController@add');
        $this->delete('/order/{order}/remove/{variation}', 'OrderController@remove');
        $this->put('/order/description/{order}', 'OrderController@description');
        $this->put('/order/status/{order}/{status}', 'OrderController@status');
        $this->resource('/order', 'OrderController');

        $this->post('/discount/{discount}/add/{variation}', 'DiscountController@add');
        $this->delete('/discount/{discount}/remove/{variation}', 'DiscountController@remove');
        $this->resource('/discount', 'DiscountController');
        
        $this->resource('/promocode', 'PromocodeController');
    });
    
    $this->group([ 'namespace' => 'Group' ], function () {

        $this->resource('/category', 'CategoryController');
        $this->resource('/subject', 'SubjectController');
    });

    $this->group([ 'namespace' => 'Feature' ], function () {

        $this->resource('/brand', 'BrandController');
        $this->resource('/color', 'ColorController');
        $this->resource('/size', 'SizeController');
        $this->resource('/warranty', 'WarrantyController');
        $this->resource('/unit', 'UnitController');
    });

    $this->group([ 'namespace' => 'User' ], function () {

        $this->resource('/role', 'RoleController');
        
        $this->post('/user/{user}/premission/{permission}/attach', 'UserController@attach_permission');
        $this->delete('/user/{user}/premission/{permission}/detach', 'UserController@detach_permission');
        $this->put('/user/{user}/password/reset', 'UserController@password_reset');
        $this->get('/user/permissions', 'UserController@permissions');
        $this->resource('/user', 'UserController');
    });

    $this->group([ 'namespace' => 'Spec' ], function () {

        $this->resource('/spec', 'SpecController');
        $this->post('/spec_header/copy/{spec_header}', 'SpecHeaderController@copy');
        $this->resource('/spec_header', 'SpecHeaderController')->only('store', 'update', 'destroy');
        $this->resource('/spec_row', 'SpecRowController')->only('store', 'update', 'destroy');
        
        // $this->resource('/spec_data', 'SpecDataController');
    });
});