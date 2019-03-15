<?php namespace App\ModelFilters\User;

use EloquentFilter\ModelFilter;

class RoleFilter extends ModelFilter
{
    /**
     * Filter the Roles that have a $string in it's name or description
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
