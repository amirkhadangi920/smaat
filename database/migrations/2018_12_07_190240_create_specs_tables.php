<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id');
                $table->foreign('category_id')->references('id')->on('categories')
                    ->onDelete('cascade')->onUpdate('cascade');
                    
            $table->string('title');
            $table->string('description', 255)->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('spec_headers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('spec_id');
            $table->foreign('spec_id')->references('id')->on('specs')
                    ->onDelete('cascade')->onUpdate('cascade');
                    
            $table->string('title', 50);
            $table->string('description', 255)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('spec_rows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('spec_header_id');
            $table->foreign('spec_header_id')->references('id')->on('spec_headers')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->string('label', 50)->nullable();
            $table->mediumText('values')->nullable();
            $table->string('help', 255)->nullable();
            $table->boolean('multiple')->default(0);
            $table->boolean('required')->default(1);
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('speceficatinos');
        Schema::dropIfExists('spec_headers');
        Schema::dropIfExists('spec_rows');
    }
}
