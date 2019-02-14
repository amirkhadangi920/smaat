<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('category_id');
                $table->foreign('category_id')->references('id')->on('categories')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->string('logo', 150)->nullable();
            $table->string('slug', 100);
            $table->string('name', 50);
            $table->string('description', 255)->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('colors', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('category_id')->nullable();
                $table->foreign('category_id')->references('id')->on('categories')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->string('name', 30);
            $table->string('code', 9)->comment('Hexadecimal code of the color, e.g #43df12');
            
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('sizes', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('category_id');
                $table->foreign('category_id')->references('id')->on('categories')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->string('name', 50);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('warranties', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('category_id');
                $table->foreign('category_id')->references('id')->on('categories')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->string('title', 50);
            $table->string('expire', 20);
            $table->string('description', 255)->nullable();
            
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
        Schema::dropIfExists('brands');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('warranties');
        Schema::dropIfExists('sizes');
    }
}
