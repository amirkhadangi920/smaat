<?php namespace App\ModelFilters\Feature;

use EloquentFilter\ModelFilter;

class UnitFilter extends ModelFilter
{
    /**
     * Filter the Units that have a $string in it's title & description
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
                ->orWhere('description', 'LIKE', "%$string%");
        });
    }

    /**
     * Filter the Units that have specific categoroy
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
