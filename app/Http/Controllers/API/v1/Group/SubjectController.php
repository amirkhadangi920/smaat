<?php

namespace App\Http\Controllers\API\v1\Group;

use App\Models\Group\Subject;
use App\Http\Resources\Group\Subject as SubjectResource;
use App\Http\Requests\v1\Group\SubjectRequest;

class SubjectController extends GroupBaseController
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'subject';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Subject::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = SubjectResource::class;
    
    /**
     * Get the request from url and pass it to storeData method
     * to create a new category in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(SubjectRequest $request)
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
    public function update(SubjectRequest $request, Subject $category)
    {
        return $this->updateWithRequest($request, $category);
    }
}