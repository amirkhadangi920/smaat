<?php

namespace App\GraphQL\Props\Feature;

use App\Models\Feature\Brand;
use App\Http\Resources\Feature\Brand as BrandResource;
use App\Http\Requests\v1\Feature\BrandRequest;
use App\ModelFilters\Feature\BrandFilter;
use App\Http\Resources\Feature\BrandCollection;

trait BrandProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'brand';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Brand::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = BrandResource::class;
    
    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = BrandCollection::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = BrandFilter::class;

    /**
     * Request class of this Type of data
     *
     * @var Request
     */
    protected $request = BrandRequest::class;

    
    protected $image_field = 'logo';
}