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

    $this->group([ 'prefix' => 'cart' ], function () {

        $this->get('/', 'CartController@index');
        $this->post('/add/{variation}/{quantity?}', 'CartController@add');
        $this->delete('/remove/{variation}', 'CartController@remove');
        $this->get('/check', 'CartController@check');
        $this->post('/payment', 'CartController@payment');
        $this->any('/payment/verify', 'CartController@verify_payment');
    });

    $this->group([ 'namespace' => 'Blog' ], function () {

        $this->get('/article/{article}/like', 'ArticleController@like');
        $this->get('/article/{article}/dislike', 'ArticleController@dislike');
        $this->apiResource('/article', 'ArticleController');
    });

    $this->group([ 'namespace' => 'Product' ], function () {

        $this->get('/product/{product}/like', 'ProductController@like');
        $this->get('/product/{product}/dislike', 'ProductController@dislike');
        $this->apiResource('/product', 'ProductController');
    });

    $this->group([ 'namespace' => 'Opinion' ], function () {

        $this->get('/comment/{comment}/like', 'CommentController@like');
        $this->get('/comment/{comment}/dislike', 'CommentController@dislike');
        $this->put('/comment/accept/{comment}', 'CommentController@accept');
        $this->apiResource('/comment', 'CommentController');

        $this->get('/review/{review}/like', 'ReviewController@like');
        $this->get('/review/{review}/dislike', 'ReviewController@dislike');
        $this->put('/review/accept/{review}', 'ReviewController@accept');
        $this->apiResource('/review', 'ReviewController');
        
        $this->put('/question_and_answer/accept/{question_and_answer}', 'QuestionAndAnswerController@accept');
        $this->apiResource('/question_and_answer', 'QuestionAndAnswerController');
    });
    
    $this->group([ 'namespace' => 'Financial' ], function () {

        $this->apiResources([
            '/shipping_method' => 'ShippingMethodContrller',
            '/order_status' => 'OrderStatusContrller',
        ]);

        $this->post('/order/{order}/add/{variation}/{quantity?}', 'OrderController@add');
        $this->delete('/order/{order}/remove/{variation}', 'OrderController@remove');
        $this->put('/order/description/{order}', 'OrderController@description');
        $this->put('/order/status/{order}/{status}', 'OrderController@status');
        $this->apiResource('/order', 'OrderController');

        $this->post('/discount/{discount}/add/{variation}', 'DiscountController@add');
        $this->delete('/discount/{discount}/remove/{variation}', 'DiscountController@remove');

        $this->apiResources([
            '/discount' => 'DiscountController',
            '/promocode' => 'PromocodeController',
        ]);
    });
    
    $this->group([ 'namespace' => 'Group' ], function () {

        $this->apiResources([
            '/category' => 'CategoryController',
            '/subject' => 'SubjectController',
        ]);
    });

    $this->group([ 'namespace' => 'Feature' ], function () {

        $this->apiResources([
            '/brand' => 'BrandController',
            '/color' => 'ColorController',
            '/size' => 'SizeController',
            '/warranty' => 'WarrantyController',
            '/unit' => 'UnitController',
        ]);
    });

    $this->group([ 'namespace' => 'User' ], function () {

        $this->apiResource('/role', 'RoleController');
        
        $this->post('/user/{user}/premission/{permission}/attach', 'UserController@attach_permission');
        $this->delete('/user/{user}/premission/{permission}/detach', 'UserController@detach_permission');
        $this->put('/user/{user}/password/reset', 'UserController@password_reset');
        $this->get('/user/permissions', 'UserController@permissions');
        $this->apiResource('/user', 'UserController');
    });

    $this->group([ 'namespace' => 'Spec' ], function () {

        $this->apiResource('/spec', 'SpecController');
        $this->post('/spec_header/copy/{spec_header}', 'SpecHeaderController@copy');
        $this->apiResource('/spec_header', 'SpecHeaderController')->except('index', 'show');
        $this->apiResource('/spec_row', 'SpecRowController')->except('index', 'show');
    });
});