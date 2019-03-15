<?php namespace App\ModelFilters\Financial;

use EloquentFilter\ModelFilter;

class DiscountFilter extends ModelFilter
{
    /**
     * Filter the Discounts that have a $string in it's title & description
     *
     * @param string $string
     * @return Builder
     */
    public function query($string)
    {
        if ( strlen($string) <= 3 ) return;

        return $this->where(function($query) use ($string)
        {
            return $query->whereLike('title', $string)
                ->orWhere('description', 'LIKE', "$$string$");
        });
    }

    /**
     * Filter the discounts that have items or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasItem ($status)
    {
        if ( $status )
            return $this->has('items');
        else
            return $this->has('items', '=', 0);
    }

    /**
     * Filter the discounts that belongs to specific categories
     *
     * @param array $ids
     * @return Builder
     */
    public function categories($ids)
    {
        return $this->whereHas('category', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
}
