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
                'info'      => 'param:name',
                'logo'      => 'nullable|array',
                'cost'      => 'integer',
                'minimum'   => 'integer|default:0|comment:Minimum factor total for this method',
                'is_active' => 'boolean|default:0',
                'jalali_created_at' => 'datetime|nullable'
            ], ['users', 'tenants']);
            
            $table->unique(['name', 'tenant_id']);
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
