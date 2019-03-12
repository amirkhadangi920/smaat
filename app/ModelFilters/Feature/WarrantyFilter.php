<?php namespace App\ModelFilters\Feature;

use EloquentFilter\ModelFilter;

class WarrantyFilter extends ModelFilter
{
    /**
     * Filter the Warranties that have a $string
     * in it's title or description or expire
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
                ->orWhere('description', 'LIKE', "%$string%")
                ->orWhere('expire', 'LIKE', "%$string%");
        });
    }

    /**
     * Filter the Warranties that have a logo or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function has_logo($logo)
    {
        if ( $logo )
            return $this->whereNotNull('logo');
        else
            return $this->whereNull('logo');
    }

    /**
     * Filter the Warranties that have specific categoriy
     *
     * @param array $ids
     * @return Builder
     */
    public function categories($ids)
    {
        return $this->whereHas('categories', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
}
