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
}
