<?php namespace App\ModelFilters\Financial;

use EloquentFilter\ModelFilter;

class PromocodeFilter extends ModelFilter
{
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
        return $this->whereHas('users', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }

    /**
     * Filter the promocodes that belongs to specific categories
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

    /**
     * Filter the promocodes that belongs to specific variations
     *
     * @param array $ids
     * @return Builder
     */
    public function variations($ids)
    {
        return $this->whereHas('variations', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
}
