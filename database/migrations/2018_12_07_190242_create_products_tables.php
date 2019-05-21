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
        
        $schema->create('products', function (Blueprint $table) {
            $table->table([
                'name'              => 50,
                'second_name'       => '50|nullable',
                'code'              => '20|nullable',
                'description'       => '255|nullable',
                'note'              => '300|nullable',
                'aparat_video'      => '10|nullable',
                'review'            => 'nullable|text',
                'photos'            => 'array',
                'advantages'        => 'array',
                'disadvantages'     => 'array',
                'label'             => 'nullable|unsignedTinyInteger',
                'views_count'       => 'unsignedInteger|default:0',
                'avg_vote'          => 'unsignedInteger|default:0',
                'votes_count'       => 'unsignedInteger|default:0',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], [
                'tenants',
                'users',
                'categories' => true,
                'brands' => true,
                'units' => true,
                'specs' => true
            ], 'uuid');
        });

        $schema->create('variations', function (Blueprint $table) {
            $table->table([
                'barcode'               => 'nullable',
                'purchase_price'        => 'integer',
                'sales_price'           => 'integer',
                'old_purchase_prices'   => 'array|comment:Array of the all prices and it\'s changing time',
                'old_sales_prices'      => 'array|comment:Array of the all prices and it\'s changing time',
                'inventory'             => 'nullable|smallInteger|comment:Null = infinite , 0 = unavailble & number = inventory', 
                'sending_time'          => 'tinyInteger|default:1|commnt:Sending time of this product variation in day, e.g 2days',
                'jalali_created_at'     => 'datetime|nullable',
                'is_active'             => 'boolean|default:1'
            ], [
                'tenants',
                'products',
                'users',
                'warranties' => true,
                'colors' => true,
                'sizes' => true
            ], 'uuid');
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
            $table->mediumText('data');
            $table->full_timestamps();
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