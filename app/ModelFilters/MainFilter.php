<?php namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class MainFilter extends ModelFilter
{
    /**
     * Add an condition to query for checking that
     * the specific feild is null or not
     *
     * @param string $field
     * @param bool $status
     * @return Query
     */
    public function has_field_or_not($field, $status)
    {
        if ( $status )
            return $this->whereNotNull( $field );
        else
            return $this->whereNull( $field );
    }

    /**
     * Add an condition to query for checking that
     * the result data has specific relation or not
     *
     * @param string $field
     * @param bool $status
     * @return Query
     */
    public function has_relation_or_not($relation, $status)
    {
        if ( $status )
            return $this->has($relation);
        else
            return $this->has($relation, '=', 0);
    }

    /**
     * Filter the Data that have specific relation
     *
     * @param string        $relation
     * @param array         $ids
     * @param string|id     $field
     * @return Query
     */
    public function filter_relation($relation, $ids, $field = 'id')
    {
        if( !is_array($ids) ) $ids = [ $ids ];

        return $this->whereHas($relation, function($query) use ($ids, $field)
        {
            $query->whereIn($field, $ids);
        });
    }
}
