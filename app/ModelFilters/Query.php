<?php

namespace App\ModelFilters;

trait Query
{
    /**
     * Filter the Brands that have a $string in it's name or description
     *
     * @param string $string
     * @return Builder
     */
    public function query($string)
    {
        $keywords = explode(' ', $string); 
        
        $waste_words = [
            'های',
            'و',
            'آیا',
            'هی',
            'تا',
            'کی',
            'خرید',
            '',
        ];

        $keywords = array_diff($keywords, $waste_words);
        
        if ( empty( $keywords ) ) return;

        return $this->where(function($query) use ($keywords)
        {
            foreach ($keywords as $keyword)
            {
                foreach ( $this->search_fields as $field )
                    $query->orWhere($field, 'LIKE', "%$keyword%");
            }
        });
    }
}