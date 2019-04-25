<?php
use App\Role;
use App\Permission;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test/amir', function() {    
    // return $permission = Permission::firstOrCreate([ 'name' => 'read-order' ]);
    return \App\User::first()->attachPermission('read-order');

    // return factory(\App\Models\Financial\OrderStatus::class, 20)->create();
    // return factory(\App\Models\Financial\Order::class, 10)->create([
    //     'user_id' => \App\User::all()->random()->id,
    //     'order_status_id' => \App\Models\Financial\OrderStatus::all()->random()->id
    // ]);
    return factory(\App\Models\Opinion\Review::class, 20)->create([
        'user_id' => \App\User::all()->random()->id,
        'product_id' => \App\Models\Product\Product::all()->random()->id
    ]);
});

Route::get('/panel/{path?}', function() {
    $dashboard_template = 'black';

    return view("dashboards.{$dashboard_template}");
})->where('path', '.*');

Route::get('/login', function() {
    return view('login');
});

// Route::view('/{vue?}', "dashboards.{$dashboard_template}")->where('vue', '[\/\w\.-]*');

// Route::resource('/article', 'panel\ArticleController');

// https://github.com/spatie/laravel-medialibrary

// https://github.com/spatie/laravel-tags

// https://github.com/dimsav/laravel-translatable

// https://github.com/cybercog/laravel-love

// https://github.com/Askedio/laravel-soft-cascade

// https://laravel-auditing.herokuapp.com/docs/4.1/audit-presentation

// https://github.com/cviebrock/eloquent-sluggable