<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateGroupingTables extends Migration
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

        $schema->create('categories', function (Blueprint $table) {
            $table->table([
                'sluggable_info',
                'depth'          => 'tinyInteger|default:1|comment:Depth of the group e.g parent > child > sub-sbhild is 3',
                'logo'           => '100|nullable',
                'scoring_feilds' => 'mediumText|nullable'
            ], ['self']);
        });

        $schema->create('subjects', function (Blueprint $table) {
            $table->table([
                'sluggable_info',
                'depth'          => 'tinyInteger|default:1|comment:Depth of the group e.g parent > child > sub-sbhild is 3',
                'logo'           => '100|nullable',
            ], ['self']);
        });

        // $schema->create('groupings', function (Blueprint $table) {
        //     $table->table([
        //         'info',
        //         'depth' => 'tinyInteger|default:1|comment:Depth of the group e.g parent > child > sub-sbhild is 3',
        //         'logo'  => '100|nullable',
        //         'type'  => '30|comment:Type of the group, e.g for accounts, incomes etc...',
        //     ], ['self']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('categories');
        $schema->dropIfExists('subjects');
        $schema->dropIfExists('account_groups');
    }
}