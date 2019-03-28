<?php

use App\Models\Category;
use App\Models\Article;


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

Route::post('/test', function() {

    return request()->all();
})->middleware('auth:api');

Route::get('{path}', function() {

    $dashboard_template = 'black';

    return view("dashboards.{$dashboard_template}");
})->where('path', '.*');

// Route::view('/{vue?}', "dashboards.{$dashboard_template}")->where('vue', '[\/\w\.-]*');

// Route::resource('/article', 'panel\ArticleController');

// https://github.com/spatie/laravel-medialibrary

// https://github.com/spatie/laravel-tags

// https://github.com/dimsav/laravel-translatable

// https://github.com/cybercog/laravel-love

// https://github.com/Askedio/laravel-soft-cascade

// https://laravel-auditing.herokuapp.com/docs/4.1/audit-presentation

// https://github.com/cviebrock/eloquent-sluggable