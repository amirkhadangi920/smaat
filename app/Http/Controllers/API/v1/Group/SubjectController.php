<?php

namespace App\Http\Controllers\API\v1\Group;

use App\Models\Group\Subject;
use App\Http\Resources\Group\Subject as SubjectResource;

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
}