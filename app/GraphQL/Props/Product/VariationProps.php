<?php

namespace App\GraphQL\Props\Product;

use App\Models\Product\Variation;
use App\Http\Requests\v1\Product\VariationRequest;

trait VariationProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'variation';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Variation::class;
    
    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = VariationRequest::class;
}