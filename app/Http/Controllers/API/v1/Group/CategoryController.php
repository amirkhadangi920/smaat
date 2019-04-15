<?php

namespace App\Http\Controllers\API\v1\Group;

use App\Models\Group\Category;
use App\Http\Resources\Group\Category as CategoryResource;
use App\Http\Requests\v1\Group\CategoryRequest;
use App\Http\Resources\Group\CategoryCollection;

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

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = CategoryCollection::class;

    /**
     * Get the request from url and pass it to storeData method
     * to create a new category in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(CategoryRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $category in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(CategoryRequest $request, Category $category)
    {
        return $this->updateWithRequest($request, $category);
    }
}