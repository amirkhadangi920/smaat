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
                'logo'              => 'nullable|array',
                'scoring_feilds'    => 'mediumText|nullable',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['self', 'users', 'tenants']);

            // $table->unique(['title', 'tenant_id']);
        });
        
        $schema->create('category_translations', function ($table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('slug', 100);
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->string('locale')->index();

            $table->unique(['category_id','locale']);
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        $schema->create('subjects', function (Blueprint $table) {
            $table->table([
                'sluggable_info',
                'logo'              => 'nullable|array',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], ['self', 'users', 'tenants']);

            // $table->unique(['title', 'tenant_id']);
        });

        $schema->create('subject_translations', function ($table) {
            $table->increments('id');
            $table->integer('subject_id')->unsigned();
            $table->string('slug', 100);
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->string('locale')->index();

            $table->unique(['subject_id','locale']);
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
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