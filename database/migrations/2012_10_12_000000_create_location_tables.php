<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('longitude‎', 12)->nullable();
            $table->string('latitude‎', 12)->nullable();
            $table->string('name', 30);
            $table->string('code', 4);
        });

        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
                $table->foreign('country_id')->references('id')->on('countries')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->string('longitude‎', 12)->nullable();
            $table->string('latitude‎', 12)->nullable();
            $table->string('name', 30);
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('province_id');
                $table->foreign('province_id')->references('id')->on('provinces')
                    ->onDelete('cascade')->onUpdate('cascade');
            $table->string('longitude‎', 12)->nullable();
            $table->string('latitude‎', 12)->nullable();
            $table->string('name', 30);
            $table->unsignedBigInteger('users_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('cities');
    }
}
