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

        $articles = factory( \App\Models\Article::class , rand(1, 10) )->create([
            'user_id' => $users->random()->id
        ]);

        $subjects->each( function($subject) use ($articles) {

            $subject->articles()->sync( $articles->random() );
        });

        $articles->each( function ( $article ) use( $users ) {

            $article->comments()->saveMany(
                 factory(\App\Models\Opinion\Comment::class, rand(1, 10))->make([
                'user_id' => $users->random()->id
            ])
            )->each( function( $comment ) use($users) {

                for( $i = 0 ; $i < rand(1, 15) ; $i++ )
                {
                    $comment->likeBy( $users->random()->id );
                }

            });    
        });
        // $articles->each( function($article) use($comments , $users) {

        //     $article->comments()->saveMany(
        //          factory( App\Models\Opinion\Comment::class ))->make([

        //             'parent_id' =>$comments->random()->id,
        //             'user_id' =>$users->random()->id
        //         ]);
        //     });

            // dd('sa;klndklank');
        echo "\e[31mArticles with it's comments \e[39mwas \e[32mcreated\n";
    }
}
