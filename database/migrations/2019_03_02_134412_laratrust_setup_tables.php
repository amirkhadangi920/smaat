<?php
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class LaratrustSetupTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        $schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function($table, $callback) {
            return new Blueprint($table, $callback);
        });

        // Create table for storing roles
        $schema->create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->add_foreign('users', true, 'uuid', null, 'set null');
            $table->add_foreign('tenants', false, 'uuid');
            $table->string('name');
            // $table->string('display_name')->nullable();
            // $table->string('description')->nullable();
            $table->dateTime('jalali_created_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamps();

            // $table->unique(['name', 'tenant_id']);
        });

        $schema->create('role_translations', function ($table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();

            $table->string('display_name')->nullable();
            $table->string('description')->nullable();

            $table->string('locale')->index();
            $table->unique(['role_id','locale']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        // Create table for storing permissions
        $schema->create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            // $table->string('display_name')->nullable();
            // $table->string('description')->nullable();
            $table->timestamps();
        });

        $schema->create('permission_translations', function ($table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();

            // $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();

            $table->string('locale')->index();
            $table->unique(['permission_id','locale']);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });

        // Create table for associating roles to users and teams (Many To Many Polymorphic)
        $schema->create('role_user', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->uuid('user_id');
            $table->string('user_type');

            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'role_id', 'user_type']);
        });

        // Create table for associating permissions to users (Many To Many Polymorphic)
        $schema->create('permission_user', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->uuid('user_id');
            $table->string('user_type');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'permission_id', 'user_type']);
        });

        // Create table for associating permissions to roles (Many-to-Many)
        $schema->create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id');

            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('permission_user');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
}
