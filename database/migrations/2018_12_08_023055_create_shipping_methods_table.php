<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateShippingMethodsTable extends Migration
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
        
        $schema->create('shipping_methods', function (Blueprint $table) {
            $table->table([
                // 'info'      => 'param:name',
                // 'logo'      => 'nullable|array',
                'cost'      => 'integer',
                'minimum'   => 'integer|default:0|comment:Minimum factor total for this method',
                'is_active' => 'boolean|default:0',
                'jalali_created_at' => 'datetime|nullable'
            ], ['users', 'tenants']);
            
            // $table->unique(['name', 'tenant_id']);
        });

        $schema->create('shipping_method_translations', function ($table) {
            $table->increments('id');
            $table->integer('shipping_method_id')->unsigned();

            $table->string('name', 50);
            $table->string('description', 255)->nullable();

            $table->string('locale')->index();
            $table->unique(['shipping_method_id','locale']);
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('articles');
    }
}
