<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('parent_id')->unsigned()->nullable();
                $table->foreign('parent_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                    
            $table->string('slug', 100);
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->tinyInteger('depth')->default(1)->comment('Depth of the group e.g parent > child > sub-sbhild is 3');
            $table->string('logo', 100)->nullable();

            $table->mediumText('scoring_feilds')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('subjects', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('parent_id')->unsigned()->nullable();
                $table->foreign('parent_id')->references('id')->on('subjects')
                    ->onDelete('cascade')->onUpdate('cascade');
                    
            $table->string('slug', 100);
            $table->string('title', 50);
            $table->string('description', 255)->nullable();
            $table->tinyInteger('depth')->default(1)->comment('Depth of the group e.g parent > child > sub-sbhild is 3');
            $table->string('logo', 100)->nullable();
            
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
        Schema::dropIfExists('categories');
        Schema::dropIfExists('subjects');
    }
}
