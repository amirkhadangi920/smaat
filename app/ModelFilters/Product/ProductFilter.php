<?php namespace App\ModelFilters\Product;

use EloquentFilter\ModelFilter;

class ProductFilter extends ModelFilter
{
    /**
     * Filter the Products that have a $string
     * in it's name, second name & description
     *
     * @param string $string
     * @return Builder
     */
    public function query($string)
    {
        if ( strlen($string) <= 3 ) return;

        return $this->where(function($query) use ($string)
        {
            return $query->whereLike('name', $string)
                ->orWhere('second_name', 'LIKE', "$$string$")
                ->orWhere('description', 'LIKE', "$$string$");
        });
    }
    
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
     * Filter the Products base on it's label
     *
     * @param string $label
     * @return Builder
     */
    public function label($label)
    {
        return $this->whereLike('label', $label);
    }

    /**
     * Filter the Products that has advantages or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasAdvantages($status)
    {
        if ( $status )
            return $this->whereNotNull('advantages');
        else
            return $this->whereNull('advantages');
    }

    /**
     * Filter the Products that has disadvantages or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasDisadvantages($status)
    {
        if ( $status )
            return $this->whereNotNull('disadvantages');
        else
            return $this->whereNull('disadvantages');
    }

    /**
     * Filter the Products that has video or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasVideo($status)
    {
        if ( $status )
            return $this->whereNotNull('aparat_video');
        else
            return $this->whereNull('aparat_video');
    }

    /**
     * Filter the products that have reviews or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasReviews($status)
    {
        if ( $status )
            return $this->has('reviews');
        else
            return $this->has('reviews', '=', 0);
    }

    /**
     * Filter the products that have specification table or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasTable($status)
    {
        if ( $status )
            return $this->has('spec_data');
        else
            return $this->has('spec_data', '=', 0);
    }

    /**
     * Filter the products that have accessories or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasAccessory($status)
    {
        if ( $status )
            return $this->has('accessories');
        else
            return $this->has('accessories', '=', 0);
    }

    /**
     * Filter the Products that belongs to specific categories
     *
     * @param array $ids
     * @return Builder
     */
    public function categories($ids)
    {
        return $this->whereHas('category', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
    
    /**
     * Filter the Products that have the specific units
     *
     * @param array $ids
     * @return Builder
     */
    public function units($ids)
    {
        return $this->whereHas('unit', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
    
    /**
     * Filter the Products that have the specific brands
     *
     * @param array $ids
     * @return Builder
     */
    public function brands($ids)
    {
        return $this->whereHas('brand', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
    
    /**
     * Filter the Products that have the specific colors
     *
     * @param array $ids
     * @return Builder
     */
    public function colors($ids)
    {
        return $this->whereHas('variation.color', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }

    /**
     * Filter the Products that have the specific sizes
     *
     * @param array $ids
     * @return Builder
     */
    public function sizes($ids)
    {
        return $this->whereHas('variation.size', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }

    /**
     * Filter the Products that have the specific warranties
     *
     * @param array $ids
     * @return Builder
     */
    public function warranties($ids)
    {
        return $this->whereHas('variation.warranty', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
}
