<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->unsignedInteger('subject_id');
                $table->foreign('subject_id')->references('id')->on('subjects')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->uuid('user_id');
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');
                    
            $table->string('slug', 100);
            $table->string('title', 50);
            $table->string('description', 255);
            $table->text('body');
            $table->string('image', 100);
            $table->integer('reading_time')->nullable()->comment('How much time need for reading the article in minute');

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
        Schema::dropIfExists('articles');
    }
}
