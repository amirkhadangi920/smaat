<?php namespace App\ModelFilters\Opinion;

use App\ModelFilters\MainFilter;
use App\ModelFilters\SimpleOrdering;

class ReviewFilter extends MainFilter
{
    use SimpleOrdering;

    /**
     * Filter the Reviews that has advantages or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasAdvantages($status)
    {
        return $this->has_field_or_not('advantages', $status);
    }

    /**
     * Filter the Reviews that has disadvantages or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasDisadvantages($status)
    {
        return $this->has_field_or_not('disadvantages', $status);
    }

    /**
     * Filter the Reviews that wrote by specific user
     *
     * @param string $id
     * @return Builder
     */
    public function writers($ids)
    {
        return $this->filter_relation('user', $ids);
    }

    /**
     * Filter the Comments that wrote for specific products
     *
     * @param array $ids
     * @return Builder
     */
    public function products($ids)
    {
        return $this->filter_relation('product', $ids);
    }
}
