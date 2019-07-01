<?php namespace App\ModelFilters\Spec;

use App\ModelFilters\MainFilter;
use App\ModelFilters\Query;
use App\ModelFilters\SimpleOrdering;

class SpecFilter extends MainFilter
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
        'headers'       => 'relation',
        'products'      => 'relation',
    ];
    
    /**
     * Filter the the Spec table that have headers or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasHeader($status)
    {
        return $this->has_relation_or_not('headers', $status);
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
     * Filter the the Spec table that have rows or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasRow($status)
    {
        return $this->has_relation_or_not('rows', $status);
    }

    /**
     * Filter the Spec table that have specific categoroy
     *
     * @param array $ids
     * @return Builder
     */
    public function categories($ids)
    {
        return $this->filter_relation('categories', $ids);
    }
}
