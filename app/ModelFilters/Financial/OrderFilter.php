<?php namespace App\ModelFilters\Financial;

use EloquentFilter\ModelFilter;

class OrderFilter extends ModelFilter
{
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
        if ( $status )
            return $this->whereNotNull('descriptions');
        else
            return $this->whereNull('descriptions');
    }

    /**
     * Filter the Orders that has docs or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasDocs($status)
    {
        if ( $status )
            return $this->whereNotNull('docs');
        else
            return $this->whereNull('docs');
    }

    /**
     * Filter the Orders that have used discount or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasDiscount($status)
    {
        if ( $status )
            return $this->has('discount');
        else
            return $this->has('discount', '=', 0);
    }

    /**
     * Filter the Orders that has paid or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function isPaid($status)
    {
        if ( $status )
            return $this->whereNotNull('paid_at');
        else
            return $this->whereNull('paid_at');
    }

    /**
     * Filter the Orders that belongs to specific users
     *
     * @param array $ids
     * @return Builder
     */
    public function buyers($ids)
    {
        return $this->whereHas('user', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }

    /**
     * Filter the Orders that is in specific statuses
     *
     * @param array $ids
     * @return Builder
     */
    public function statuses($ids)
    {
        return $this->whereHas('order_status', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
    
    /**
     * Filter the Orders with it's shipping method
     *
     * @param array $ids
     * @return Builder
     */
    public function shipping_methods($ids)
    {
        return $this->whereHas('shipping_method', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
    
    /**
     * Filter the Orders with it's buyer cities
     *
     * @param array $ids
     * @return Builder
     */
    public function cities($ids)
    {
        return $this->whereHas('city', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
}
