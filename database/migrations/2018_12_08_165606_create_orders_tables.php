<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');
            
            $table->string('code', 20);
            $table->integer('value');
            $table->dateTime('using_time')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('buyer_id');
                $table->foreign('buyer_id')->references('id')->on('users')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedInteger('discount_code_id')->nullable();
                $table->foreign('discount_code_id')->references('id')->on('discount_codes')
                    ->onDelete('cascade')->onUpdate('cascade');
            
            $table->mediumText('descriptions')->nullable()->comment('Array of the orders descriptions');
            
            $table->unsignedInteger('city_id')->nullable();
            $table->string('destination', 255)->nullable();
            $table->string('postal_code', 10)->nullable();

            $table->mediumText('shipping')->nullable()->comment('Array of shipping cost and price');
            
            $table->bigInteger('offer')->default(0);
            $table->bigInteger('total')->default(0);

            $table->string('status', 20)->default('created')->comment('Status of the order');
            $table->datetime('payment')->nullable();
            $table->datetime('payment_jalali')->nullable();

            $table->string('auth_code', 50)->nullable();
            $table->string('payment_code', 30)->nullable();
            $table->mediumText('datetimes')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('order_id');
                $table->foreign('order_id')->references('id')->on('orders')
                    ->onDelete('cascade')->onUpdate('cascade');
                        
            $table->uuid('variation_id')->nullable();
                $table->foreign('variation_id')->references('id')->on('variations')
                    ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('count')->unsigned();
            $table->bigInteger('price')->unsigned()->default(0);
            $table->bigInteger('offer')->unsigned()->default(0);

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
        Schema::dropIfExists('orders');

        Schema::dropIfExists('order_products');

        Schema::dropIfExists('discount_codes');
    }
}
