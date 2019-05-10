<?php namespace App\ModelFilters\Financial;

use App\ModelFilters\MainFilter;
use App\ModelFilters\Query;
use App\ModelFilters\SimpleOrdering;

class ShippingMethodFilter extends MainFilter
{
    use Query, SimpleOrdering;

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $search_fields = [
        'name',
        'description',
    ];

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $ordering_items = [
        'cost'      => 'feild',
        'minimum'   => 'feild',
        'orders'    => 'relation',
    ];

    /**
     * Filter the Shipping method that have a logo or not
     *
     * @param boolean $status
     * @return Builder
     */
    public function hasLogo($status)
    {
        return $this->has_field_or_not('logo', $status);
    }
}