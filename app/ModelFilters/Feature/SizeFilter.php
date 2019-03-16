<?php namespace App\ModelFilters\Feature;

class SizeFilter extends FeatureBaseFilter
{
    /**
     * Define this type of data had has_logo filter
     *
     * @var boolean
     */
    protected $has_logo = false;

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $search_fields = [
        'name',
    ];
}
