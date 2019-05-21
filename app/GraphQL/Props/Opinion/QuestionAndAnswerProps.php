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
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'product:id,name,photos,label',
        'user:id,first_name,last_name,avatar',
        'answers:id,user_id,question_id,message,is_accept,created_at,updated_at',
        'answers.user:id,first_name,last_name,avatar'
    ];

    /**
     * Name of the relation method of the User model to this model
     *
     * @var string
     */
    protected $rel_from_user = 'questionAndAnswers';

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
}