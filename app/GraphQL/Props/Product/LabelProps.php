<?php

namespace App\GraphQL\Props\Product;

use App\Models\Product\Label;
use App\Http\Requests\v1\Product\LabelRequest;

trait LabelProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'label';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Label::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = LabelRequest::class;
}