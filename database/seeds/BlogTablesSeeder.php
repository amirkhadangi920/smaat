<?php

use Illuminate\Database\Seeder;

class BlogTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( $users )
    {
        $subjects = factory(\App\Models\Group\Subject::class, rand(1,5))->create();
        $subjects->each( function ( $subject ) use ( &$subjects ) {

            $subjects = $subjects->merge( $subject->childs()->saveMany(
                factory(\App\Models\Group\Subject::class, rand(1,5))->make()
            ));
        });

        $users->each( function ( $user ) use ( $subjects, $users ) {
            
            $user->articles()->saveMany( factory(\App\Models\Article::class, rand(0, 10))->make([
                'subject_id' => $subjects->random()->id
            ]) )->each( function ( $article ) use( $users ) {

                $article->comments()->saveMany( factory(\App\Models\Opinion\Comment::class, rand(0, 10))->make([
                    'user_id' => $users->random()->id
                ]) );
            });
            
        });
        echo "\e[31mArticles with it's comments \e[39mwas \e[32mcreated\n";
    }
}
