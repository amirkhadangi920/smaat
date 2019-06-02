<?php

namespace App\GraphQL\Props\Opinion;

use App\Models\Opinion\QuestionAndAnswer;
use App\Http\Resources\Opinion\QuestionAndAnswer as QuestionAndAnswerResource;
use App\ModelFilters\Opinion\QuestionAndAnswerFilter;
use App\Http\Requests\v1\Opinion\QuestionAndAnswerRequest;
use App\Http\Resources\Opinion\QuestionAndAnswerCollection;

trait QuestionAndAnswerProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'question_and_answer';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = QuestionAndAnswer::class;

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = QuestionAndAnswerResource::class;

    /**
     * Resource Collection of this controller respnoses
     *
     * @var [type]
     */
    protected $collection = QuestionAndAnswerCollection::class;
    
    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = QuestionAndAnswerFilter::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = QuestionAndAnswerRequest::class;
}