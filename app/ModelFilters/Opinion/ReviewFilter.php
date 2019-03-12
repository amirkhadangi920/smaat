<?php namespace App\ModelFilters\Opinion;

use EloquentFilter\ModelFilter;

class ReviewFilter extends ModelFilter
{
    /**
     * Filter the Reviews that wrote by specific user
     *
     * @param string $id
     * @return Builder
     */
    public function writers($ids)
    {
        return $this->whereHas('user', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }

    /**
     * Filter the Reviews that has advantages or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasAdvantages($status)
    {
        if ( $status )
            return $this->whereNotNull('advantages');
        else
            return $this->whereNull('advantages');
    }

    /**
     * Filter the Reviews that has disadvantages or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasDisadvantages($status)
    {
        if ( $status )
            return $this->whereNotNull('disadvantages');
        else
            return $this->whereNull('disadvantages');
    }

    /**
     * Filter the Comments that wrote for specific products
     *
     * @param array $ids
     * @return Builder
     */
    public function products($ids)
    {
        return $this->whereHas('product', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
}
