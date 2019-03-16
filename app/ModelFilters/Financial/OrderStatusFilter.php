<?php namespace App\ModelFilters\Financial;

use App\ModelFilters\MainFilter;
use App\ModelFilters\Query;

class OrderStatusFilter extends MainFilter
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
