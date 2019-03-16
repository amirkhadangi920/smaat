<?php namespace App\ModelFilters\Financial;

use App\ModelFilters\MainFilter;
use App\ModelFilters\SimpleOrdering;

class PromocodeFilter extends MainFilter
{
    use SimpleOrdering;

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $ordering_items = [
        'value'         => 'feild',
        'min_total'     => 'feild',
        'expired_at'    => 'feild',
        'orders'        => 'relation',
        'categories'    => 'relation',
        'variations'    => 'relation',
    ];

    /**
     * Filter the Promocodes base on it's code
     *
     * @param string $code
     * @return Builder
     */
    public function code($code)
    {
        return $this->whereLike('code', $code);
    }

    /**
     * Filter the promocodes that was expired or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function isExpired($status)
    {
        if ( $status )
            return $this->where('expired_at', '<', now());
        else
            return $this->where('expired_at', '>', now());
    }

    /**
     * Filter the promocodes that belongs to specific users
     *
     * @param array $ids
     * @return Builder
     */
    public function users($ids)
    {
        return $this->filter_relation('users', $ids);
    }

    /**
     * Filter the promocodes that belongs to specific categories
     *
     * @param array $ids
     * @return Builder
     */
    public function categories($ids)
    {
        return $this->filter_relation('categories', $ids);
    }

    /**
     * Filter the promocodes that belongs to specific variations
     *
     * @param array $ids
     * @return Builder
     */
    public function variations($ids)
    {
        return $this->filter_relation('variations', $ids);
    }
}
