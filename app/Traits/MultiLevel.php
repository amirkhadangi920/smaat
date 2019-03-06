<?php namespace App\Traits;

trait MultiLevel
{
    /**
     * Get a breadcrump for specified group
     * e.g parnet > child > sub-child ...
     *
     * @param Model $group
     * @return Array
     */
    public static function breadcrumb ($group)
    {
        $breadcrumb = collect([$group]);

        if ( is_null($group->parent_id) )
            return $breadcrumb->pluck('title', 'slug');
        
        do {
            $breadcrumb->push( $breadcrumb->last()->parent );
        } while ( $breadcrumb->last()->parent );

        return $breadcrumb->pluck('title', 'slug');
    }

    /**
     * Get all the groups in tree style
     *
     * @return collection $groups
     */
    public static function tree()
    {
        $groups = static::select('id', 'slug', 'title', 'logo')
                ->whereNull('parent_id')->latest()->get();

        $groups->each( function ( $group ) {
            static::get_childs( $group );
        });

        return $groups;
    }

    /**
     * Recursive function for geting the childs of the group,
     * if group has child, run this method on all of it's childs recursive
     *
     * @param Model $groups
     * @return void
     */
    public static function get_childs($groups)
    {
        $groups->load('childs:parent_id,slug,title');

        if ( $groups->childs->isNotEmpty() )
        {
            foreach ( $groups->childs as $child )
                static::get_childs( $child );
        } else {
            unset( $groups->childs );
        }
    }
}