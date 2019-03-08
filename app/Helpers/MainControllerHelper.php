<?php

namespace App\Helpers;

trait MainControllerHelper
{
    /**
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData()
    {
        $data = $this->model::latest();
        
        if ( isset( $this->relations ) )
            $data->with( $this->relations );

        return $data->paginate(20);
    }

    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function getSingleData($data)
    {
        if ( isset( $this->relations ) )
        {
            if ( isset( $this->more_relations ) )
                $this->relations = array_merge( $this->relations, $this->more_relations );
                
            return $this->model::with( $this->relations )->findOrFail($data);
        }
        else
            return $this->model::findOrFail($data);
    }

    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function getModel($data)
    {
        return $this->model::findOrFail($data);
    }

    /**
     * Find an get a data from Database,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function createNewModel($data)
    {
        return $this->model::create( $data );
    }

    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest( $request)
    {
        return $request->all();
    }

    /**
     * Check the request to it'has image or not,
     * then create a data with appropirate method
     *
     * @param Request $request
     * @return void
     */
    public function storeWithImageOrNot($request)
    {
        if ( isset($this->image_field) )
        {
            return $this->createNewModel(
                $this->getRequest(
                    $this->requestWithImage( $request, $this->image_field )
                )
            );
        }
        else
        {
            return $this->createNewModel( $this->getRequest( $request ) );
        }
    }
    
    /**
     * Check the request to it'has image or not,
     * then update the data with appropirate method
     *
     * @param Request $request
     * @return void
     */
    public function updateWithImageOrNot($request, $data)
    {
        if ( isset($this->image_field) )
        {
            $data->update(
                $this->getRequest(
                    $this->requestWithImage( $request, $this->image_field, $data )
                )
            );
        }
        else
        {
            $data->update( $this->getRequest( $request ) );
        }
    }

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterCreate($request, $data)
    {
        if ( isset( $this->relations ) )
            $data->load( $this->relations );
    }
    
    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $data
     * @return void
     */
    public function afterUpdate($request, $data)
    {
        if ( isset( $this->relations ) )
            $data->load( $this->relations );
    }
}