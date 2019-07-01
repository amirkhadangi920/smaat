<?php namespace App\ModelFilters\Product;

use App\ModelFilters\MainFilter;
use App\ModelFilters\Query;
use App\ModelFilters\SimpleOrdering;

class ProductFilter extends MainFilter
{
    use Query, SimpleOrdering;

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $ordering_items = [
        'favorites'  => 'relation',
        'reviews'  => 'relation',
        'questions'  => 'relation',
        'accessories'  => 'relation',
    ];
    
    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $search_fields = [
        'name',
        'second_name',
        'description',
    ];

    /**
     * Filter the Products base on it's codes
     *
     * @param string $code
     * @return Builder
     */
    public function code($code)
    {
        return $this->whereLike('code', $code);
    }
       
    /**
     * Filter the Data that have active or not
     *
     * @param boolean $status
     * @return Builder
     */
    public function isActive($status)
    {
        return $this->where('is_active', $status);
    }

    /**
     * Filter the Products that has advantages or not
     *
     * @param boolean $status
     * @return Builder
     */
    public function hasAdvantages($status)
    {
        return $this->has_field_or_not('advantages', $status);
    }

    /**
     * Filter the Products that has disadvantages or not
     *
     * @param boolean $status
     * @return Builder
     */
    public function hasDisadvantages($status)
    {
        return $this->has_field_or_not('disadvantages', $status);
    }

    /**
     * Filter the Products that has video or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasVideo($status)
    {
        return $this->has_field_or_not('aparat_video', $status);
    }

    /**
     * Filter the products that have reviews or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasReviews($status)
    {
        return $this->has_relation_or_not('reviews', $status);
    }

    /**
     * Filter the products that have specification table or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasTable($status)
    {
        return $this->has_relation_or_not('spec_data', $status);
    }

    /**
     * Filter the products that have accessories or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasAccessory($status)
    {
        return $this->has_relation_or_not('accessories', $status);
    }

    /**
     * Filter the Products that belongs to specific categories
     *
     * @param array $ids
     * @return Builder
     */
    public function categories($ids)
    {
        return $this->filter_relation('categories', $ids);
    }
    
    /**
     * Filter the Products that have the specific units
     *
     * @param array $ids
     * @return Builder
     */
    public function units($ids)
    {
        return $this->filter_relation('unit', $ids);
    }
    
    /**
     * Filter the Products that have the specific brands
     *
     * @param array $ids
     * @return Builder
     */
    public function brands($ids)
    {
        return $this->filter_relation('brand', $ids);
    }
    
    /**
     * Filter the Products that have the specific colors
     *
     * @param array $ids
     * @return Builder
     */
    public function colors($ids)
    {
        return $this->filter_relation('variation.color', $ids);
    }

    /**
     * Filter the Products that have the specific sizes
     *
     * @param array $ids
     * @return Builder
     */
    public function sizes($ids)
    {
        return $this->filter_relation('variation.size', $ids);
    }

    /**
     * Filter the Products that have the specific warranties
     *
     * @param array $ids
     * @return Builder
     */
    public function warranties($ids)
    {
        return $this->filter_relation('variation.warranty', $ids);
    }
}
