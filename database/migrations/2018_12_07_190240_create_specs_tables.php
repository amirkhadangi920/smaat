<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateSpecsTables extends Migration
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
        
        $schema->create('specs', function (Blueprint $table) {
            $table->id();
            $table->reltoCategories();
            $table->reltoUsers();
            $table->reltoTenants();
            // $table->info();
            $table->full_timestamps();
            $table->dateTime('jalali_created_at')->nullable();
            $table->boolean('is_active')->default(1);
            // $table->unique(['title', 'tenant_id']);
        });

        $schema->create('spec_translations', function ($table) {
            $table->increments('id');
            $table->integer('spec_id')->unsigned();
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->string('locale')->index();

            $table->unique(['spec_id','locale']);
            $table->foreign('spec_id')->references('id')->on('specs')->onDelete('cascade');
        });

        $schema->create('spec_headers', function (Blueprint $table) {
            $table->id();
            $table->reltoSpecs();
            $table->reltoUsers();
            // $table->info();
            $table->boolean('is_active')->default(1);
            $table->full_timestamps();
        });

        $schema->create('spec_header_translations', function ($table) {
            $table->increments('id');
            $table->integer('spec_header_id')->unsigned();
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->string('locale')->index();

            $table->unique(['spec_header_id','locale']);
            $table->foreign('spec_header_id')->references('id')->on('spec_headers')->onDelete('cascade');
        });

        $schema->create('spec_rows', function (Blueprint $table) {
            $table->table([
                // 'info',
                // 'label'     => '50|nullable',
                'values'    => 'array',
                // 'help'      => '255|nullable',
                'multiple'  => 'default:0',
                'required'  => 'default:1',
                'is_active' => 'boolean|default:1'
            ], ['spec_headers', 'users']);
        });

        $schema->create('spec_row_translations', function ($table) {
            $table->increments('id');
            $table->integer('spec_row_id')->unsigned();
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->string('label', 50);
            $table->string('help', 255)->nullable();
            $table->string('locale')->index();

            $table->unique(['spec_row_id','locale']);
            $table->foreign('spec_row_id')->references('id')->on('spec_rows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('speceficatinos');
        $schema->dropIfExists('spec_headers');
        $schema->dropIfExists('spec_rows');
    }
}
