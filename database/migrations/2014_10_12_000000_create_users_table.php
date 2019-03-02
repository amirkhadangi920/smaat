<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateUsersTable extends Migration
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

        $schema->create('users', function (Blueprint $table) {
            $table->table([
                'first_name'        => '20|nullable',
                'last_name'         => '30|nullable',
                'phones'            => 'array|comment:Array of user phone numbers',
                'social_links'      => 'array|comment:Array of user social links, e.g instagram, telegram etc...',
                'email'             => '100|unique',
                'email_verified_at' => 'timestamp|nullable',
                'password'          => 100,
                'avatar'            => '50|nullable',
                
                'address'           => '300|nullable',
                'postal_code'       => '10|nullable',
                'national_code'     => '10|nullable',

                'type'              => 'tinyInteger|default:0',
                'rememberToken',
                'purchase_counts'   => 'unsignedInteger|default:0',
                'total_payments'    => 'unsignedInteger|default:0',
            ], [ 'cities' => true ], 'uuid', [ 'last_purchase' ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('users');
    }
}
