<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateOptionsTables extends Migration
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
        
        $schema->create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->add_foreign('tenants', false, 'uuid');
            $table->name(50);
            // $table->string('type', 20);
            $table->timestamps();
        });

        $schema->create('site_setting_translations', function ($table) {
            $table->increments('id');
            $table->integer('site_setting_id')->unsigned();
            $table->mediumText('value', 50)->nullable();
            $table->string('locale')->index();
            $table->unique(['site_setting_id','locale']);
            $table->foreign('site_setting_id')->references('id')->on('site_settings')->onDelete('cascade');
        });

        $schema->create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->add_foreign('users', false, 'uuid');
            $table->name(50);
            // $table->string('type', 20);
            $table->timestamps();
        });

        $schema->create('user_setting_translations', function ($table) {
            $table->increments('id');
            $table->integer('user_setting_id')->unsigned();
            $table->mediumText('value', 50)->nullable();
            $table->string('locale')->index();
            $table->unique(['user_setting_id','locale']);
            $table->foreign('user_setting_id')->references('id')->on('user_settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('options');
    }
}
