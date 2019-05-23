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
                'info'              => 'param:name',
                'logo'              => 'nullable|array',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['users', 'tenants']);
            
            // $table->unique(['name', 'tenant_id']);
        });

        $schema->create('colors', function ($table) {
            $table->table([
                'name'              => 30,
                'code'              => '9|comment:Hexadecimal code of the color, e.g #43df12',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['users', 'tenants']);

            // $table->unique(['name', 'tenant_id']);
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

        $schema->create('warranties', function ($table) {
            $table->table([
                'info',
                'logo'              => 'nullable|array',
                'expire'            => 20,
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['users', 'tenants']);

            // $table->unique(['title', 'tenant_id']);
        });

        $schema->create('units', function ($table) {
            $table->table([
                'info',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['users', 'tenants']);

            // $table->unique(['title', 'tenant_id']);
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
