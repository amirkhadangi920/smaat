<?php

namespace App\Traits\Controllers;

use Illuminate\Http\Request;

trait FeatureControllers
{
    /**
     * Display a listing of the group.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => $this->model::latest()->get(),
            'message' => __('messages.return.all', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Store a newly created group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->checkPermission("create-{$this->type}");

        if ( isset($this->image_field) )
        {
            $feature = $this->model::create(
                $this->requestWithImage( $request, $this->image_field )->all()
            );
        }
        else
        {
            $feature = $this->model::create( $request->all() );
        }
        
        return (new $this->resource( $feature ))->additional([
            'message' => __('messages.create.successful', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Display the specified group with it's breadcrumb.
     *
     * @param  Model $feature
     * @return ModelResource
     */
    public function show($feature)
    {
        $feature = $this->model::whereSlug($feature)->firstOrFail();

        return (new $this->resource( $feature ))->additional([
            'message' => __('messages.return.single', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);;
    }

    /**
     * Update the specified group in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $feature)
    {
        $this->checkPermission("update-{$this->type}");

        $feature = $this->model::whereSlug($feature)->firstOrFail();

        if ( isset($this->image_field) )
        {
            $feature->update(
                $this->requestWithImage( $request, $this->image_field, $feature )->all()
            );
        }
        else
        {
            $feature->update( $request->all() );
        }

        
        return (new $this->resource( $feature ))->additional([
            'message' => __('messages.update.successful', [
                'data' => __("types.{$this->type}.title")
            ])
        ]);
    }

    /**
     * Remove the one or multiple groups from storage.
     *
     * @param  String $features
     * @return Array\JSON
     */
    public function destroy($features)
    {
        $this->checkPermission("delete-{$this->type}");
        
        $features = explode(',', $features);

        foreach ( $features as $feature )
        {
            Model::whereSlug($feature)->firstOrfail()->delete();
        }

        $status = count($features) === 1 ? 'successful' : 'plural';
        
        return response()->json([
            'message' => __("messages.delete.{$status}", [
                'data' => __("types.{$this->type}.title")
            ])
        ]); 
    }
}