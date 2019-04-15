<?php

namespace App\Http\Controllers\API\v1\Opinion;

use App\Models\Opinion\QuestionAndAnswer;
use App\Http\Resources\Opinion\QuestionAndAnswer as QuestionAndAnswerResource;
use App\ModelFilters\Opinion\QuestionAndAnswerFilter;
use App\Http\Requests\v1\Opinion\QuestionAndAnswerRequest;
use App\Http\Resources\Opinion\QuestionAndAnswerCollection;

class QuestionAndAnswerController extends OpinionBaseController
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
        'answers:id,user_id,question_id,message,created_at',
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

    /**
     * Get the request from url and pass it to storeData method
     * to create a new question_and_answer in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(QuestionAndAnswerRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $question_and_answer in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(QuestionAndAnswerRequest $request, QuestionAndAnswer $question_and_answer)
    {
        return $this->updateWithRequest($request, $question_and_answer);
    }

    /**
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        return $this->model::select('id', 'question_id', 'product_id', 'user_id', 'message', 'created_at', 'updated_at')
            ->filter( request()->all(), $this->filter )    
            ->whereNull('question_id')
            ->with($this->relations)
            ->latest()
            ->paginate( $this->getPerPage() );
    }
}
