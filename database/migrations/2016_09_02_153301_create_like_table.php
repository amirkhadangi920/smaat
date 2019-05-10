<?php

/*
 * This file is part of Laravel Likeable.
 *
 * (c) Anton Komarev <a.komarev@cybercog.su>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Helpers\Blueprint;

/**
 * Class CreateLikeTable.
 */
class CreateLikeTable extends Migration
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

        $schema->create('like', function (Blueprint $table) {
            $table->increments('id');
            $table->morphs('likeable');
            $table->uuid('user_id')->index();
            $table->enum('type_id', [
                'like',
                'dislike',
            ])->default('like');
            $table->timestamp('created_at')->nullable();

            $table->unique([
                'likeable_id',
                'likeable_type',
                'user_id',
            ], 'like_user_unique');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('like');
    }
}
