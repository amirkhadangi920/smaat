<?php namespace App\ModelFilters\Spec;

use EloquentFilter\ModelFilter;

class SpecFilter extends ModelFilter
{
    /**
     * Filter the Spec table that have a $string in it's name & description
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
     * Filter the the Spec table that have headers or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasHeader($status)
    {
        if ( $status )
            return $this->has('headers');
        else
            return $this->has('headers', '=', 0);
    }
    
    /**
     * Filter the the Spec table that have rows or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasRow($status)
    {
        if ( $status )
            return $this->has('headers.rows');
        else
            return $this->has('headers.rows', '=', 0);
    }

    /**
     * Filter the Spec table that have specific categoroy
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
