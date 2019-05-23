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
            $table->info();
            $table->full_timestamps();
            $table->dateTime('jalali_created_at')->nullable();
            $table->boolean('is_active')->default(1);
            // $table->unique(['title', 'tenant_id']);
        });

        $schema->create('spec_headers', function (Blueprint $table) {
            $table->id();
            $table->reltoSpecs();
            $table->reltoUsers();
            $table->info();
            $table->boolean('is_active')->default(1);
            $table->full_timestamps();
        });

        $schema->create('spec_rows', function (Blueprint $table) {
            $table->table([
                'info',
                'label'     => '50|nullable',
                'values'    => 'array',
                'help'      => '255|nullable',
                'multiple'  => 'default:0',
                'required'  => 'default:1',
                'is_active' => 'boolean|default:1'
            ], ['spec_headers', 'users']);
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
