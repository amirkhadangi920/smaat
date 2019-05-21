<?php
use App\Role;
use App\Permission;
use App\Models\Feature\Brand;
use App\Models\Product\Product;
use App\Models\Article;
use App\Events\Feature\BrandCreated;

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

    event( new BrandCreated() );
    return 'Brand was created';

    return [
        'ua' => $_SERVER['HTTP_USER_AGENT']
    ];

    return Brand::find(4)->creator;

    auth()->loginUsingId( \App\User::first()->id );

    // return auth()->user();

    // return Product::first()->update(['brand_id' => 4]);

    // return Product::first()->audits;

    return Brand::find(4)->update([
        'name' => 'another name',
        'description' => 'test the tags'
    ]);

    return Article::find('11d113a4407f')->audits->last()->load('user');

    return \App\Models\Product\Product::find('14d28843aeeb')->accessories;

    return \App\Models\Group\Category::with([
        'spec:id,category_id',
        'spec.headers:id,spec_id',
        'spec.headers.rows' => function ($query) {
            $query->whereNotNull('values');
        }
    ])->first();

    return \App\Models\Article::find('3c86114b957e')->attachTags([
        'test',
        'test2',
        'amir',
    ]);

    // return \App\Models\Group\Category::count();

    \App\Models\Discount\Discount::first()->items()->updateOrCreate([
        'variation_id' => \App\Models\Product\Variation::all()->random()->id,
    ], [
        'offer'     => rand(0, 60),
        'quantity'  => rand(1, 10),
    ]);

    return \App\Models\Discount\Discount::withCount('items')->first();

    return factory(\App\User::class)->create();
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