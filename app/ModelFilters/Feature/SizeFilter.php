<?php namespace App\ModelFilters\Feature;

use EloquentFilter\ModelFilter;

class SizeFilter extends ModelFilter
{
    /**
     * Filter the Sizes that have a $string in it's name
     *
     * @param string $string
     * @return Builder
     */
    public function query($string)
    {
        if ( strlen($string) <= 3 ) return;

        return $this->whereLike('name', $string);
    }

    /**
     * Filter the Sizes that have specific categoroy
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
