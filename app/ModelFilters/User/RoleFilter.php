<?php namespace App\ModelFilters\User;

use App\ModelFilters\MainFilter;
use App\ModelFilters\Query;

class RoleFilter extends MainFilter
{
    use Query;
    
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
     * Filter the Data that have active or not
     *
     * @param boolean $status
     * @return Builder
     */
    public function isActive($status)
    {
        return $this->where('is_active', $status);
    }
}
