<?php

namespace App\Http\Controllers\API\v1\Opinion;

use App\Models\Opinion\QuestionAndAnswer;
use App\Http\Resources\Opinion\QuestionAndAnswer as QuestionAndAnswerResource;

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
        'product:id,slug,name,photos,label',
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
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        return $this->model::select('id', 'question_id', 'user_id', 'message', 'created_at')
            ->whereNull('question_id')
            ->with($this->relations)
            ->latest()
            ->paginate( $this->getPerPage() );
    }
}
