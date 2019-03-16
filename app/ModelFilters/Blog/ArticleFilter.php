<?php namespace App\ModelFilters\Blog;

use App\ModelFilters\MainFilter;
use App\ModelFilters\Query;
use App\ModelFilters\SimpleOrdering;

class ArticleFilter extends MainFilter
{
    use Query, SimpleOrdering;

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $search_fields = [
        'title',
        'description',
    ];

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $ordering_items = [
        'reading_time'  => 'feild',
        'comments'      => 'relation',
        'likes'         => 'relation',
        'dislikes'      => 'relation'
    ];

    /**
     * Filter the Articles that have subject or not
     *
     * @param boolean $status
     * @return Builder
     */
    public function hasSubject($status)
    {
        return $this->has_relation_or_not('subjects', $status);
    }

    /**
     * Filter the Articles that wrote by specific wirter
     *
     * @param string $id
     * @return Builder
     */
    public function writers($ids)
    {
        return $this->filter_relation('user', $ids);
    }

    /**
     * Filter the Articles that have specific subject
     *
     * @param array $ids
     * @return Builder
     */
    public function subjects($ids)
    {
        return $this->filter_relation('subjects', $ids);
    }
}
