<?php

namespace App\ModelFilters;

use Illuminate\Support\Str;


trait SimpleOrdering
{
    /**
     * Set latest ordering if is not prefer by user 
     *
     * @return void
     */
    public function setup()
    {
        if ( !request('ordering', false) )
            return $this->latest();
    }


    /**
     * Manage the list ordering item
     *
     * @param string $type
     * @return void
     */
    public function ordering($type)
    {
        if( $type === 'latest')
            return $this->latest();

        elseif( $type === 'oldest')
            return $this->orderBy('created_at', 'asc');

        elseif ( $this->ordering_items ?? false )
        {
            if ( Str::startsWith($type, 'max_') )
            {
                $type = Str::replaceFirst('max_', '', $type);
                $sort = 'desc';
            }
            elseif ( Str::startsWith($type, 'min_') )
            {
                $type = Str::replaceFirst('min_', '', $type);
                $sort = 'asc';
            }


            if ( !($this->ordering_items[$type] ?? false) ) return;


            if ( $this->ordering_items[$type] === 'relation' )
                return $this->withCount($type)->orderBy("{$type}_count", $sort);

            elseif ( $this->ordering_items[$type] === 'feild' )
                return $this->orderBy($type, $sort);
        }
    }
}