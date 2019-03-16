<?php namespace App\ModelFilters\Financial;

use App\ModelFilters\MainFilter;
use App\ModelFilters\Query;
use App\ModelFilters\SimpleOrdering;

class DiscountFilter extends MainFilter
{
    use Query, SimpleOrdering;

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $search_fields = [
        'title',
        'description',
    ];

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $ordering_items = [
        'start_at'      => 'feild',
        'expired_at'    => 'feild',
        'orders'        => 'relation',
    ];

    /**
     * Filter the discounts that have items or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasItem ($status)
    {
        return $this->has_relation_or_not('items', $status);
    }

    /**
     * Filter the discounts that belongs to specific categories
     *
     * @param array $ids
     * @return Builder
     */
    public function categories($ids)
    {
        return $this->filter_relation('category', $ids);
    }
}
