<?php

namespace App\GraphQL\Props\Group;

use App\Models\Group\Category;
use App\Http\Requests\v1\Group\CategoryRequest;

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
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'logo';

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = CategoryRequest::class;
}