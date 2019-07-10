<?php

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

Route::get('/panel/{path?}', function() {
    $dashboard_template = 'black';

    return view("dashboards.{$dashboard_template}");
})->where('path', '.*');

Route::get('/login', function() {
    
    return view('comming-soon');
    
    return view('login');
});

Route::get('/{path?}', function() {

    return view('comming-soon');

    $dashboard_template = 'karma';

    return view("themplates.{$dashboard_template}");
})->where('path', '.*');