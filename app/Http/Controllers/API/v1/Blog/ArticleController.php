<?php

namespace App\Http\Controllers\API\v1\Blog;

use App\Models\Article;
use App\Http\Controllers\API\v1\MainController;
use App\Helpers\SluggableController;
use App\Helpers\HasUser;
use App\Http\Resources\Blog\Article as ArticleResource;
use App\ModelFilters\Blog\ArticleFilter;
use App\Http\Requests\v1\Article\ArticleRequest;
use App\Helpers\LikeableController;

class ArticleController extends MainController
{
    use SluggableController, HasUser, LikeableController;

    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'article';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = Article::class;

    /**
     * The relation of the controller to get when accesing data from DB
     *
     * @var array
     */
    protected $relations = [
        'subjects',
        'user:id:first_name,last_name'
    ];

    protected $more_relations = [
        'tags:name,slug'
    ];

    /**
     * Resource of this controller respnoses
     *
     * @var [type]
     */
    protected $resource = ArticleResource::class;

    /**
     * Filter class of this eloquent model
     *
     * @var ModelFilter
     */
    protected $filter = ArticleFilter::class;

    /**
     * Name of the field that should upload an image from that
     *
     * @var string
     */
    protected $image_field = 'image';

    /**
     * Name of the relation method of the User model to this model
     *
     * @var string
     */
    protected $rel_from_user = 'articles';
    
    /**
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        return $this->model::select('id', 'user_id', 'slug', 'title', 'description', 'image', 'reading_time')
            ->filter( request()->all(), $this->filter )    
            ->with( $this->relations )
            ->latest()
            ->paginate( $this->getPerPage() );
    }

    /**
     * Get the request from url and pass it to storeData method
     * to create a new article in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function store(ArticleRequest $request)
    {
        return $this->storeWithRequest($request);
    }

    /**
     * Get the request from url and pass it to updateData method
     * to update the $brand in storage
     *
     * @param  Request  $request
     * @return Array
     */
    public function update(ArticleRequest $request, Article $article)
    {
        return $this->updateWithRequest($request, $article);
    }
    
    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterCreate($request, $article)
    {
        $article->subjects()->attach( $request->subjects );
        $article->attachTags($request->keywords);
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterUpdate($request, $article)
    {
        $article->subjects()->sync( $request->subjects );
        $article->syncTags($request->keywords);
    }
}