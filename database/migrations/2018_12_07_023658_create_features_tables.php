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
                'logo' => '150|nullable',
                'sluggable_info' => 'param:name'
            ], [ 'categories']);
        });

        $schema->create('colors', function ($table) {
            $table->table([
                'name' => 30,
                'code' => '9|comment:Hexadecimal code of the color, e.g #43df12',
            ], [ 'categories']);
        });

        $schema->create('sizes', function ($table) {
            $table->table([
                'name' => 50,
            ], [ 'categories']);
        });

        $schema->create('warranties', function ($table) {
            $table->table([
                'info',
                'expire' => 20,
            ], [ 'categories']);
        });

        $schema->create('units', function ($table) {
            $table->table([
                'info',
            ], [ 'categories']);
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
