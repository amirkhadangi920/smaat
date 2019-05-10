<?php

namespace App\Helpers;

Trait SluggableController
{
    /**
     * The field to manage as primary key
     *
     * @var boolean
     */
    protected $primary_feild = 'slug';

    /**
     * Find an get a data from Database with slug field,
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
                
            return $this->model::with( $this->relations )->whereSlug($data)->firstOrFail();
        }
        else
            return $this->model::whereSlug($data)->firstOrFail();
    }
    /**
     * Find an get a data from Database with slug field,
     * or abort 404 not found exception if can't find
     *
     * @param ID $feature
     * @return Model
     */
    public function getModel($brand)
    {
        return $this->model::whereSlug($brand)->firstOrFail();
    }
}
