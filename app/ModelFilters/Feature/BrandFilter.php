<?php namespace App\ModelFilters\Feature;

use EloquentFilter\ModelFilter;

class BrandFilter extends ModelFilter
{
    /**
     * Filter the Brands that have a $string in it's name or description
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
                ->orWhere('description', 'LIKE', "%$string%");
        });
    }

    /**
     * Filter the Brands that have a logo or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasLogo($logo)
    {
        if ( $logo )
            return $this->whereNotNull('logo');
        else
            return $this->whereNull('logo');
    }

    /**
     * Filter the Brands that have specific categoriy
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
