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

use Vinkla\Instagram\Instagram;
use App\User;
use App\Models\Group\Category;
use App\Models\Feature\Size;
use App\Models\Spec\SpecRow;
use App\Models\Spec\SpecData;
use App\Models\Option\SiteSetting;
use App\Models\Financial\OrderStatus;
use App\Models\Financial\Order;
use App\Models\Group\ScoringField;
use App\Models\Opinion\Review;
use App\Models\Product\Variation;
use App\Models\Places\Country;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use App\Models\Promocode\Promocode;
use App\Models\Spec\SpecHeader;
use App\Models\Spec\SpecDefault;

Route::get('/test/amir', function() {

    $row = SpecRow::find(1);

    return $row->data()->where('product_id', 'a367bea6ed91')->first()->values;

    // auth()->loginUsingId('f47370015075');

    return $brand = Brand::select('id')->with('media')->first();

    // $brand
    //     ->addMedia( public_path('images/user-test.jpg') )
    //     ->preservingOriginal()
    //     ->toMediaCollection();

    // $brand->clearMediaCollection();


    // return $brand_logo = $brand;
    // return $brand_logo = $brand->load('media')->media[0]->getCustomProperty('primaryColor');
    return $brand_logo = $brand->load('media')->media[0]->getFullUrl('small');


    // return SpecRow::find(59)->defaults()->saveMany( factory(SpecDefault::class, 5)->make() );

    
    return auth()->user()->allPermissions();

    return Category::find(1)->load('spec');


    auth()->login( User::first() );
    return factory(Promocode::class)->create();

    return Country::create([
        'name' => 'a country',
        'coordinates' => new Point(48.7484404, -73.9878441)
    ]);

    return Country::select(['id', 'name', 'coordinates'])->first()->coordinates;

    return Variation::first()->old_sale_prices;

    return Category::find(1)->scoring_fields()->create([
        'title' => 'فیلد امتیازی 2',
        'description' => 'یک توضیح خیلی کوتاه',
        'default' => 4
    ]);

    return Order::first()->status_changes->pluck('pivot.changed_at');

    auth()->login( App\User::first() );
    return factory(OrderStatus::class)->create([ 'id' => 1 ]);

    return SiteSetting::all()->pluck('value', 'name');

    // return Product::whereHas('spec_data.values', function($query) {
    //     $query->where('spec_default_id', 103);
    // })->get();


    // return Product::find('94e37004cf02');

    return Category::select('id')->find(87)->spec->filterRows;


    return SpecRow::first()->defaults;

    // return app()->getLocale();

    // auth()->loginUsingId( User::first()->id );

    return Product::search('یک')->get();
    return Article::search('یک مقاله درباره چنگیز خان مغول')->get();

    return Role::all();

    Brand::create([
        'fa' => [
            'name' => 'نام جدید',
            'description' => 'توضیحات'
        ],
        'en' => [
            'name' => 'the name',
            'description' => 'the description'
        ]
    ]);

    return Brand::latest()->with('audits')->first();

    app()->setLocale('en');

    return Brand::whereHas('translations')->get();

    return Brand::whereHas('translations', function ($query) {
        $query->where('name', 'like', '%another%');
    })->get();

    // return Brand::find(6)->update(['name' => 'anothers name']);


    $instagram = new Instagram('465864457.1677ed0.4672896c0971489ab5cabf1c7e327fb6');
    // return $instagram->media();
    return $instagram->comments('2004349022115828714_465864457');

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