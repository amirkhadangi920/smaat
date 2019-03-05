<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;
class CreateOrderTeble extends Migration
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
        
        $schema->create('order_statuses', function (Blueprint $table) {
            $table->table([
                'info',
                'cost' => 'unsignedInteger',
            ]);
        });

        $schema->create('orders', function (Blueprint $table) {
            $table->table([
                'descriptions'      => 'array',
                'destination'       => '255|nullable',
                'postal_code'       => '10|nullable',
                
                'offer'             => 'bigInteger|default:0',
                'total'             => 'bigInteger|default:0',
                'tax'               => 'bigInteger|default:0',

                'docs'              => 'array|comment:Array of documentation images',
                'status'            => '20|default:created|comment:Status of the order',
                'checkout'          => 'boolean|default:0',
                'auth_code'         => '50|nullable',
                'payment_code'      => '30|nullable',
                // 'payment_jalali'    => 'timestamp',
                'datetimes'         => 'mediumText|nullable',
                'status'            => 'boolean|default:0',
                'type'              => 'tinyInteger|comment:Type of factor, e.g sell, buy, sell_back etc...',
                'is_accept'         => 'boolean|default:0'
            ], [
                'users',
                'order_statuses',
                'promocodes' => true,
                'shipping_methods' => true,
                'cities' => true,
            ], 'uuid', ['paid_at', 'jalali_paid_at']);            
        });

        $schema->create('orders_items', function (Blueprint $table) {
            $table->table([
                'count' => 'unsignedInteger',
                'price' => 'unsignedBigInteger|default:0',
                'offer' => 'unsignedBigInteger|default:0',
                'tax'   => 'unsignedBigInteger|default:0',
                'description' => '255|nullable',
            ], [
                // 'users',
                'orders',
                'variations' => true,
            ], 'uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('factor_items');
        $schema->dropIfExists('factors');
        $schema->dropIfExists('discount_codes');
        $schema->dropIfExists('accounts');
        $schema->dropIfExists('transactions');
    }
}
