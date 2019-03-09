<?php

namespace App\Http\Controllers\API\v1\Group;

use App\Models\Group\Category;
use App\Http\Resources\Group\Category as CategoryResource;

class CategoryController extends GroupBaseController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'category';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Category::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = CategoryResource::class;
}