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
                'logo' => 'nullable|array',
                'sluggable_info' => 'param:name'
            ], [ ]);
        });

        $schema->create('colors', function ($table) {
            $table->table([
                'name' => 30,
                'code' => '9|comment:Hexadecimal code of the color, e.g #43df12',
            ], [ ]);
        });

        $schema->create('sizes', function ($table) {
            $table->table([
                'name' => 50,
            ], [ ]);
        });

        $schema->create('warranties', function ($table) {
            $table->table([
                'info',
                'logo' => 'nullable|array',
                'expire' => 20,
            ], [ ]);
        });

        $schema->create('units', function ($table) {
            $table->table([
                'info',
            ], [ ]);
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
