<?php namespace App\ModelFilters\Opinion;

use App\ModelFilters\MainFilter;
use App\ModelFilters\SimpleOrdering;

class QuestionAndAnswerFilter extends MainFilter
{
    use SimpleOrdering;

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $ordering_items = [
        'answers' => 'relation'
    ];

    /**
     * Filter the comments that have answer or not
     *
     * @param boolean $status
     * @return Builder
     */
    public function hasAnswer($status)
    {
        return $this->has_relation_or_not('answers', $status);
    }

    /**
     * Filter the Comments that wrote by specific user
     *
     * @param string $id
     * @return Builder
     */
    public function writers($ids)
    {
        return $this->filter_relation('user', $ids);
    }

    /**
     * Filter the Comments that wrote for specific products
     *
     * @param array $ids
     * @return Builder
     */
    public function products($ids)
    {
        return $this->filter_relation('product', $ids);
    }
}
