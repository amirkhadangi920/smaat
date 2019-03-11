<?php

namespace App\Http\Controllers\API\v1\Group;

use Illuminate\Http\Request;
use App\Helpers\SluggableController;
use App\Http\Controllers\API\v1\MainController;

class GroupBaseController extends MainController
{
    use SluggableController;

    /**
     * More realtion to use in show method of the controller
     *
     * @var array
     */
    protected $more_relations = [
        'parent',
        'childs'
    ];

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'logo';

    /**
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        return $this->model::tree();
    }

    /**
     * Display the specified group with it's breadcrumb.
     *
     * @param  Model $feature
     * @return ModelResource
     */
    public function show($group)
    {
        $group = $this->getSingleData( $group );

        return (new $this->resource( $group, $this->model::breadcrumb($group) ))->additional([
            'message' => __('messages.return.single', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);;
    }
}