<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateProductsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function($table, $callback) {
            return new Blueprint($table, $callback);
        });
        
        $schema->create('labels', function (Blueprint $table) {
            $table->table([
                'color'             => '9|comment:Hexadecimal code of the color, e.g #43df12',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], [
                'tenants',
                'users',
            ]);

            // $table->unique(['name', 'tenant_id']);
        });

        $schema->create('label_translations', function ($table) {
            $table->increments('id');
            $table->integer('label_id')->unsigned();
            
            $table->string('title', 50);
            $table->string('description', 250)->nullable();

            $table->string('locale')->index();
            $table->unique(['label_id','locale']);
            $table->foreign('label_id')->references('id')->on('labels')->onDelete('cascade');
        });

        $schema->create('products', function (Blueprint $table) {
            $table->table([
                'code'              => '20|nullable',
                'note'              => '300|nullable',
                'aparat_video'      => '10|nullable',
                // 'photos'            => 'array',
                'views_count'       => 'unsignedInteger|default:0',
                'avg_vote'          => 'unsignedInteger|default:0',
                'votes_count'       => 'unsignedInteger|default:0',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], [
                'tenants',
                'users',
                'brands' => ['nullable', 'set null'],
                'labels' => ['nullable', 'set null'],
                'units' => ['nullable', 'set null'],
                'specs' => ['nullable', 'set null']
            ], 'uuid');

            // $table->unique(['name', 'tenant_id']);
        });
        
        $schema->create('product_translations', function ($table) {
            $table->increments('id');
            $table->uuid('product_id');
            
            $table->string('slug', 100);
            $table->string('name', 50);
            $table->array('second_name');
            $table->string('description', 255)->nullable();
            $table->text('short_review')->nullable();
            $table->text('expert_review')->nullable();
            $table->array('advantages');
            $table->array('disadvantages');

            $table->string('locale')->index();

            $table->unique(['product_id','locale']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        $schema->create('product_category', function($table) {
            $table->interface('products', 'categories');
        });

        $schema->create('product_color', function($table) {
            $table->interface('products', 'colors');
        });

        $schema->create('variations', function (Blueprint $table) {
            $table->table([
                'barcode'               => 'nullable',
                'purchase_price'        => 'integer',
                'sales_price'           => 'integer',
                // 'old_purchase_prices'   => 'array|comment:Array of the all prices and it\'s changing time',
                // 'old_sales_prices'      => 'array|comment:Array of the all prices and it\'s changing time',
                'inventory'             => 'nullable|smallInteger|comment:Null = infinite , 0 = unavailble & number = inventory', 
                'sending_time'          => 'nullable|tinyInteger|default:1|commnt:Sending time of this product variation in day, e.g 2days',
                'jalali_created_at'     => 'datetime|nullable',
                'is_active'             => 'boolean|default:1'
            ], [
                'tenants',
                'products',
                'users',
                'warranties' => ['nullable', 'set null'],
                'colors' => ['nullable', 'set null'],
                'sizes' => ['nullable', 'set null']
            ], 'uuid');
        });

        $schema->create('price_changes', function ($table) {
            $table->increments('id');
            $table->add_foreign('variations', false, 'uuid');
            $table->integer('old_price');
            $table->boolean('type')->default(0);
            $table->timestamp('changed_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        });

        $schema->create('order_points', function (Blueprint $table) {
            $table->integer('value')->default(0);
            $table->morphs('orderable');
        });

        $schema->create('accessories', function (Blueprint $table) {
            $table->reltoProducts();
            $table->add_foreign('products', false, 'uuid', 'accessory_id');
            
            $table->primary(['product_id', 'accessory_id']);
        });

        $schema->create('spec_data', function (Blueprint $table) {
            $table->id();
            $table->reltoSpec_rows();
            $table->reltoProducts();
            // $table->mediumText('data');
            $table->full_timestamps();
        });

        
        
        $schema->create('spec_data_translations', function ($table) {
            $table->increments('id');
            $table->integer('spec_data_id')->unsigned();
            
            $table->mediumText('data')->nullable();
            
            $table->string('locale')->index();

            $table->unique(['spec_data_id','locale']);
            $table->foreign('spec_data_id')->references('id')->on('spec_data')->onDelete('cascade');
        });

        $schema->create('spec_data_values', function (Blueprint $table) {
            $table->add_foreign('spec_data', false, 'unsignedInteger', 'spec_data_id');
            $table->reltoSpec_defaults();

            $table->primary([ 'spec_data_id', 'spec_default_id' ]);
        });

        $schema->create('favorites', function (Blueprint $table) {
            $table->interface('users', 'products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('products');
        $schema->dropIfExists('variations');
        $schema->dropIfExists('accessories');
        $schema->dropIfExists('spec_data');
    }
}