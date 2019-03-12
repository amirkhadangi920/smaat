<?php namespace App\ModelFilters\Financial;

use EloquentFilter\ModelFilter;

class OrderStatusFilter extends ModelFilter
{
    /**
     * Filter the Order statues that have a $string in it's name & description
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
                ->orWhere('description', 'LIKE', "$$string$");
        });
    }
}
