<?php namespace App\ModelFilters\Financial;

use EloquentFilter\ModelFilter;

class ShippingMethodFilter extends ModelFilter
{
    /**
     * Filter the Shipping method that have a $string in it's name & description
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

    /**
     * Filter the Shipping method that have a logo or not
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
}