<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Group\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Group\Category as CategoryResource;
use App\Http\Resources\Group\CategoryCollection;
use App\Permission;

class CategoryController extends Controller
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    private $type = 'category';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Category::tree(),
            'message' => __('messages.return.all', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->checkPermission('create-category');

        $category = Category::create(
            $this->requestWithImage( $request )->merge([
                'scoring_feilds' => $request->scoring_feilds ? explode(',', $request->scoring_feilds) : null
            ])->all()
        );
        
        return (new CategoryResource( $category ))->additional([
            'message' => __('messages.create.successful', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Display the specified category with it's breadcrumb.
     *
     * @param  Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        return (new CategoryResource( $category, Category::breadcrumb( $category ) ))->additional([
            'message' => __('messages.return.single', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->checkPermission('update-category');

        $category->update(
            $this->requestWithImage( $request, 'logo', $category )->merge([
                'scoring_feilds' => $request->scoring_feilds ? explode(',', $request->scoring_feilds) : null
            ])->all()
        );
        
        return (new CategoryResource( $category ))->additional([
            'message' => __('messages.update.successful', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Remove the one or multiple categories from storage.
     *
     * @param  String $categories
     * @return Array\JSON
     */
    public function destroy($categories)
    {
        $categories = explode(',', $categories);

        $this->checkPermission('delete-category');

        foreach ( $categories as $category )
        {
            Category::whereSlug($category)->firstOrfail()->delete();
        }

        $status = count($categories) === 1 ? 'successful' : 'plural';
        
        return response()->json([
            'message' => __("messages.delete.{$status}", [
                'data' => __("types.{$this->type}.title")
            ])
        ]); 
    }
}