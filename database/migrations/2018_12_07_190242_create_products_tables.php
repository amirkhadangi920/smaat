<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('user_id');
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('category_id')->unsigned()->nullable();
                $table->foreign('category_id')->references('id')->on('categories')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('brand_id')->unsigned()->nullable();
                $table->foreign('brand_id')->references('id')->on('brands')
                    ->onDelete('set null')->onUpdate('set null');

            $table->integer('spec_id')->unsigned()->nullable();
                $table->foreign('spec_id')->references('id')->on('specs')
                    ->onDelete('set null')->onUpdate('set null');
                    
            $table->string('slug', 100);
            $table->string('name', 50);
            $table->string('second_name', 50)->nullable();
            $table->string('code', 20)->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('note')->nullable();
            $table->string('aparat_video', 8)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->text('review')->nullable();
            $table->mediumText('keywords')->nullable()->comment('Array of the product keywords');
            $table->mediumText('photos')->nullable()->comment('Array of product photos');
            $table->mediumText('advantages')->nullable()->comment('Array of the product advantages');
            $table->mediumText('disadvantages')->nullable()->comment('Array of the product disadvantages');
            $table->string('label', 20)->nullable();

            $table->unsignedInteger('views_count')->default(0);

            $table->unsignedInteger('avg_vote')->default(0);
            $table->unsignedInteger('votes_count')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('variations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('product_id');
                $table->foreign('product_id')->references('id')->on('products')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('warranty_id')->nullable();
                $table->foreign('warranty_id')->references('id')->on('warranties')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('color_id')->nullable();
                $table->foreign('color_id')->references('id')->on('colors')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('size_id')->nullable();
                $table->foreign('size_id')->references('id')->on('sizes')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('price');
            $table->mediumText('old_prices')->nullable()->comment('Array of the all prices and it\'s changing time');
            $table->integer('offer')->nullable()->comment('special price of the product with offer');
            $table->timestamp('offer_deadline')->nullable();
            $table->smallInteger('inventory')->nullable()->comment('Null = infinite , 0 = unavailble & number = inventory');

            $table->tinyInteger('sending_time')->default(1)->comment('Sending time of this product variation in day, e.g 2days');

            $table->boolean('status')->default(1)->comment('Enable/Disable showing the variation');
            
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('product_accessory', function (Blueprint $table) {
            $table->uuid('product_id');
                $table->foreign('product_id')->references('id')->on('products')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->uuid('accessory_id');
                $table->foreign('accessory_id')->references('id')->on('products')
                        ->onDelete('cascade')->onUpdate('cascade');
            
            $table->primary(['product_id', 'accessory_id']);
        });

        Schema::create('spec_data', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('spec_row_id');
            $table->foreign('spec_row_id')->references('id')->on('spec_rows')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->uuid('product_id');
            $table->foreign('product_id')->references('id')->on('products')
                    ->onDelete('cascade')->onUpdate('cascade');
                    
            $table->mediumText('data');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('favorites', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->uuid('product_id');
            $table->foreign('product_id')->references('id')->on('products')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->primary(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('variations');
        Schema::dropIfExists('accessories');
        Schema::dropIfExists('spec_data');
    }
}
