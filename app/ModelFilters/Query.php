<?php

namespace App\ModelFilters;

trait Query
{
    /**
     * Filter the data by a given string
     *
     * @param string $string
     * @return Builder
     */
    public function query($string)
    {
        $this->search($string);
    }
}