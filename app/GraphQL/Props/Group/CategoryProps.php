<?php

namespace App\GraphQL\Props\Group;

use App\Models\Group\Category;
use App\Http\Resources\Group\Category as CategoryResource;
use App\Http\Requests\v1\Group\CategoryRequest;
use App\Http\Resources\Group\CategoryCollection;

trait CategoryProps
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

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = CategoryCollection::class;
}