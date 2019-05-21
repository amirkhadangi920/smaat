<?php

namespace App\GraphQL\Mutation\Feature;

trait FeaturesCategoriesMutation
{
    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterCreate($request, $feature)
    {
        $feature->categories()->attach( $request->get('categories') );
    }
    
    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterUpdate($request, $feature)
    {
        $feature->categories()->sync( $request->categories );
    }
}