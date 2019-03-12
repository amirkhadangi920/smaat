<?php namespace App\ModelFilters\Feature;

use EloquentFilter\ModelFilter;

class ColorFilter extends ModelFilter
{
    /**
     * Filter the Colors that have a $string
     * in it's name or color code value
     *
     * @param string $string
     * @return Builder
     */
    public function query($string)
    {
        if ( strlen($string) <= 3 ) return;

        return $this->where(function($query) use ($string)
        {
            return $query->whereLike('name', $string)
                ->orWhere('code', $string);
        });
    }

    /**
     * Filter the Colors that have specific categoroy
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
