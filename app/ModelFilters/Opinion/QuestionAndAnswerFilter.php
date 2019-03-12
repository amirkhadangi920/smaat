<?php namespace App\ModelFilters\Opinion;

use EloquentFilter\ModelFilter;

class QuestionAndAnswerFilter extends ModelFilter
{
    /**
     * Filter the Comments that wrote by specific user
     *
     * @param string $id
     * @return Builder
     */
    public function writers($ids)
    {
        return $this->whereHas('user', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }

    /**
     * Filter the comments that have answer or not
     *
     * @param boolean $logo
     * @return Builder
     */
    public function hasAnswer($answer)
    {
        if ( $answer )
            return $this->has('answers');
        else
            return $this->has('answers', '=', 0);
    }

    /**
     * Filter the Comments that wrote for specific products
     *
     * @param array $ids
     * @return Builder
     */
    public function products($ids)
    {
        return $this->whereHas('product', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
}
