<?php namespace App\ModelFilters\Financial;

use App\ModelFilters\MainFilter;
use App\ModelFilters\SimpleOrdering;

class OrderFilter extends MainFilter
{
    use SimpleOrdering;

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $ordering_items = [
        'offer'     => 'feild',
        'total'     => 'feild',
        'paid_at'   => 'feild',
    ];

    /**
     * Filter the Orders base on it's id
     *
     * @param string $code
     * @return Builder
     */
    public function id($id)
    {
        return $this->whereLike('id', $id);
    }
    
    /**
     * Filter the Orders base on it's address
     *
     * @param string $code
     * @return Builder
     */
    public function address($id)
    {
        return $this->whereLike('destination', $id);
    }
    
    /**
     * Filter the Orders base on it's postal code
     *
     * @param string $code
     * @return Builder
     */
    public function postalCode($id)
    {
        return $this->whereLike('postal_code', $id);
    }

    /**
     * Filter the Orders that has descriptions or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasDescriptions($status)
    {
        return $this->has_field_or_not('descriptions', $status);
    }

    /**
     * Filter the Orders that has docs or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasDocs($status)
    {
        return $this->has_field_or_not('docs', $status);
    }

    /**
     * Filter the Orders that have used discount or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasDiscount($status)
    {
        return $this->has_relation_or_not('discount', $status);
    }

    /**
     * Filter the Orders that has paid or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function isPaid($status)
    {
        return $this->has_field_or_not('paid_at', $status);
    }

    /**
     * Filter the Orders that belongs to specific users
     *
     * @param array $ids
     * @return Builder
     */
    public function buyers($ids)
    {
        return $this->filter_relation('user', $ids);
    }

    /**
     * Filter the Orders that is in specific statuses
     *
     * @param array $ids
     * @return Builder
     */
    public function statuses($ids)
    {
        return $this->filter_relation('order_status', $ids);
    }
    
    /**
     * Filter the Orders with it's shipping method
     *
     * @param array $ids
     * @return Builder
     */
    public function shipping_methods($ids)
    {
        return $this->filter_relation('shipping_method', $ids);
    }
    
    /**
     * Filter the Orders with it's buyer cities
     *
     * @param array $ids
     * @return Builder
     */
    public function cities($ids)
    {
        return $this->filter_relation('city', $ids);
    }
}
