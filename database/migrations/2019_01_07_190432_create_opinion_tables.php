<?php

use Illuminate\Support\Facades\Schema;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Blueprint;

class CreateOpinionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schema = DB::connection()->getSchemaBuilder();

        $schema->blueprintResolver(function($table, $callback) {
            return new Blueprint($table, $callback);
        });
        
        $schema->create('comments', function (Blueprint $table) {
            $table->id();
            $table->add_foreign();
            $table->relations([
                'users' => true,
                'articles' => true,
            ]);
            $table->mediumText('message');
            $table->boolean('is_accept')->defult(false);
            $table->dateTime('jalali_created_at')->nullable();
            $table->full_timestamps();
        });
        
        $schema->create('reviews', function (Blueprint $table) {
            $table->table([
                'ranks' => 'array',
                'advantages' => 'array',
                'disadvantages' => 'array',
                'message' => 'mediumText',
                'is_accept' =>  'boolean|defult:false',
                'jalali_created_at' => 'datetime|nullable'
            ], [
                'users' => true,
                'products' => true,
            ]);
        });
        
        $schema->create('question_and_answers', function (Blueprint $table) {
            $table->id();
            $table->relations([
                'users' => true,
                'products' => true,
            ]);
            $table->add_foreign('question_and_answers', true, 'unsignedInteger', 'question_id');
            $table->mediumText('message');
            $table->boolean('is_accept')->defult(false);
            $table->dateTime('jalali_created_at')->nullable();
            $table->full_timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schema->dropIfExists('comments');
        $schema->dropIfExists('reviews');
        $schema->dropIfExists('question_and_answers');
    }
}
