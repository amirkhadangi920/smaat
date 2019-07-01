<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateArticlesTable extends Migration
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

        $schema->create('articles', function (Blueprint $table) {
            $table->table([
                // 'sluggable_info',
                // 'body',
                // 'image'             => 'array',
                'reading_time'      => 'nullable|mediumInteger|comment:How much time need for reading the article in minute',
                'jalali_created_at' => 'datetime|nullable',
                'is_active'         => 'boolean|default:1'
            ], [
                'tenants',
                'users',
            ], 'uuid');

            // $table->unique(['title', 'tenant_id']);
        });

        $schema->create('article_translations', function ($table) {
            $table->increments('id');
            $table->uuid('article_id');

            $table->string('slug', 100);
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->text('body');

            $table->string('locale')->index();
            $table->unique(['article_id','locale']);
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });

        $schema->create('article_subject', function (Blueprint $table) {
            $table->interface('articles', 'subjects');
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
