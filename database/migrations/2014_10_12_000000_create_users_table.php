<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('first_name', 20)->nullable();
            $table->string('last_name', 30)->nullable();

            $table->mediumText('phones')->nullable()->comment('Array of user phone numbers');
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 100);
            $table->string('avatar', 50)->nullable();
            
            $table->unsignedInteger('city_id')->nullable();
                $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->string('address', 255)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('national_code', 10)->nullable();

            $table->tinyInteger('type')->default(0);
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
