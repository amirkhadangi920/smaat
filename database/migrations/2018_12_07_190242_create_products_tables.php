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
                'slug'          => 100,
                'name'          => 50,
                'second_name'   => '50|nullable',
                'code'          => 'nullable',
                'description'   => 'nullable',
                'note'          => 'nullable',
                'aparat_video'  => 'nullable',
                'status'        => 'nullable|default:1|tinyInteger',
                'review'        => 'nullable|text',
                'keywords'      => 'array',
                'photos'        => 'array',
                'advantages'    => 'array',
                'disadvantages' => 'array',
                'label'         => '0|nullable',
                'views_count'   => 'unsignedInteger|default:0',
                'avg_vote'      => 'unsignedInteger|default:0',
                'votes_count'   => 'unsignedInteger|default:0',
            ], [
                'users',
                'categories' => true,
                'brands' => true,
                'units' => true,
                'specifications' => true
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
                'status'                => 'boolean|default:1|comment:Enable/Disable showing the variation'
            ], [
                'products',
                'warranties' => true,
                'colors' => true,
                'sizes' => true
            ], 'uuid');
        });

        $schema->create('ordering_points', function (Blueprint $table) {
            $table->integer('value')->default(0);
            $table->morphs('orderable');
        });

        $schema->create('accessories', function (Blueprint $table) {
            $table->reltoProducts();
            $table->add_foreign('products', false, 'uuid', 'accessory_id');
            
            $table->primary(['product_id', 'accessory_id']);
        });

        $schema->create('specification_data', function (Blueprint $table) {
            $table->id();
            $table->reltoSpecification_rows();
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