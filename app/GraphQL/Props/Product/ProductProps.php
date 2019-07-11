<?php

namespace App\GraphQL\Props\Product;

use App\Models\Product\Product;
use App\Http\Resources\Product\Product as ProductResource;
use App\ModelFilters\Product\ProductFilter;
use App\Http\Requests\v1\Product\ProductRequest;
use App\Http\Resources\Product\ProductCollection;

trait ProductProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'product';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Product::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = ProductResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = ProductCollection::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = ProductFilter::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = ProductRequest::class;
}