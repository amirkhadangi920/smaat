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
                'social_links'      => 'array|comment:Array of user social links, e.g instagram, telegram etc...',
                'email'             => '100',
                'email_verified_at' => 'timestamp|nullable',
                'password'          => 100,
                'national_code'     => '10|nullable',
                'gender'            => 'nullable|boolean',

                'rememberToken',
                'purchase_counts'   => 'unsignedInteger|default:0',
                'total_payments'    => 'unsignedInteger|default:0',
                'jalali_created_at' => 'datetime|nullable'
            ], [], 'uuid', [ 'last_purchase' ]);
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
