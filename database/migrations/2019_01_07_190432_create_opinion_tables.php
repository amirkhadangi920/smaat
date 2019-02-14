<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpinionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');
            
            $table->uuid('article_id')->nullable();
                    $table->foreign('article_id')->references('id')->on('articles')
                        ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('parent_id')->nullable();
                $table->foreign('parent_id')->references('id')->on('comments')
                    ->onDelete('cascade')->onUpdate('cascade');

            
            $table->mediumText('message');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('parent_id')->nullable();
                $table->foreign('parent_id')->references('id')->on('comments')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->uuid('product_id')->nullable();
                $table->foreign('product_id')->references('id')->on('products')
                    ->onDelete('cascade')->onUpdate('cascade');
            
            $table->mediumText('ranks')->nullable()->comment('Array of user ranking in this review');
            $table->mediumText('advantages')->nullable()->comment('Array of user advantages in this review');
            $table->mediumText('disadvantages')->nullable()->comment('Array of user disadvantages in this review');
            
            $table->mediumText('message');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('question_and_answers', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('question_id')->nullable();
                $table->foreign('question_id')->references('id')->on('question_and_answers')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->uuid('product_id')->nullable();
                $table->foreign('product_id')->references('id')->on('products')
                    ->onDelete('cascade')->onUpdate('cascade');
            
            $table->mediumText('message');

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
        Schema::dropIfExists('comments');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('question_and_answers');
    }
}
