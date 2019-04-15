<?php

namespace App\Http\Controllers\API\v1\Feature;

use Illuminate\Http\Request;
use App\Http\Controllers\API\v1\MainController;

class FeatureBaseController extends MainController
{
    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'categories:id,title'
    ];

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterCreate($request, $feature)
    {
        $feature->categories()->attach( $request->categories );
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