<?php namespace App\ModelFilters\Opinion;

use App\ModelFilters\MainFilter;
use App\ModelFilters\SimpleOrdering;

class CommentFilter extends MainFilter
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
     * implementing this model filters
     *
     * @return void
     */
    public function setup()
    {
        return $this->whereNull('parent_id');
    }

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
     * Filter the Data that have accept or not
     *
     * @param boolean $status
     * @return Builder
     */
    public function isAccept($status)
    {
        return $this->where('is_accept', $status);
    }

    /**
     * Filter the Comments that wrote by specific user
     *
     * @param string $id
     * @return Builder
     */
    public function writers($ids)
    {
        return $this->filter_relation('writer', $ids);
    }

    /**
     * Filter the Comments that wrote for specific articles
     *
     * @param array $ids
     * @return Builder
     */
    public function articles($ids)
    {
        return $this->filter_relation('article', $ids);
    }
}
