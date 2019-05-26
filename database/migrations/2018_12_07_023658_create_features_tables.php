<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateFeaturesTables extends Migration
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

        $schema->create('brands', function ($table) {
            $table->table([
                // 'sluggable_info'    => 'param:name',
                'logo'              => 'nullable|array',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['users', 'tenants']);
            
            // $table->unique(['name', 'tenant_id']);
        });
        
        $schema->create('brand_translations', function ($table) {
            $table->increments('id');
            $table->integer('brand_id')->unsigned();
            $table->string('slug', 100);
            $table->string('name', 50);
            $table->string('description', 255)->nullable();
            $table->string('locale')->index();

            $table->unique(['brand_id','locale']);
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
        });

        $schema->create('colors', function ($table) {
            $table->table([
                'code'              => '9|comment:Hexadecimal code of the color, e.g #43df12',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['users', 'tenants']);

            // $table->unique(['name', 'tenant_id']);
        });

        $schema->create('color_translations', function ($table) {
            $table->increments('id');
            $table->integer('color_id')->unsigned();
            $table->string('name', 50);
            $table->string('locale')->index();

            $table->unique(['color_id','locale']);
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
        });

        $schema->create('sizes', function ($table) {
            $table->table([
                'name'              => 50,
                'description'       => 'nullable|string',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['users', 'tenants']);

            // $table->unique(['name', 'tenant_id']);
        });
        
        $schema->create('size_translations', function ($table) {
            $table->increments('id');
            $table->integer('size_id')->unsigned();
            $table->string('name', 50);
            $table->string('description', 255)->nullable();
            $table->string('locale')->index();

            $table->unique(['size_id','locale']);
            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('cascade');
        });

        $schema->create('warranties', function ($table) {
            $table->table([
                'logo'              => 'nullable|array',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['users', 'tenants']);

            // $table->unique(['title', 'tenant_id']);
        });
        
        $schema->create('warranty_translations', function ($table) {
            $table->increments('id');
            $table->integer('warranty_id')->unsigned();
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->string('expire', 20);
            $table->string('locale')->index();

            $table->unique(['warranty_id','locale']);
            $table->foreign('warranty_id')->references('id')->on('warranties')->onDelete('cascade');
        });

        $schema->create('units', function ($table) {
            $table->table([
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['users', 'tenants']);

            // $table->unique(['title', 'tenant_id']);
        });

        $schema->create('unit_translations', function ($table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->string('locale')->index();

            $table->unique(['unit_id','locale']);
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });

        $schema->create('featureables', function ($table) {
            $table->reltoCategories();
            $table->morphs('featureable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('brands');
        $schema->dropIfExists('colors');
        $schema->dropIfExists('warranties');
        $schema->dropIfExists('sizes');
    }
}
