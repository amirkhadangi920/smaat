<?php

namespace App\GraphQL\Props\Group;

use App\Models\Group\Subject;
use App\Http\Resources\Group\Subject as SubjectResource;
use App\Http\Requests\v1\Group\SubjectRequest;
use App\Http\Resources\Group\SubjectCollection;

trait SubjectProps
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
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = SubjectCollection::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = SubjectRequest::class;
}