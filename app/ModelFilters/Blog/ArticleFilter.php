<?php namespace App\ModelFilters\Blog;

use EloquentFilter\ModelFilter;

class ArticleFilter extends ModelFilter
{
    /**
     * Filter the Articles that have a $string in it's name or description
     *
     * @param string $string
     * @return Builder
     */
    public function query($string)
    {
        if ( strlen($string) <= 3 ) return;

        return $this->where(function($query) use ($string)
        {
            return $query->whereLike('title', $string)
                ->orWhere('description', 'LIKE', "%$string%");
        });
    }

    /**
     * Filter the Articles that wrote by specific wirter
     *
     * @param string $id
     * @return Builder
     */
    public function writer($id)
    {
        return $this->where('user_id', $id);
    }

    /**
     * Filter the Articles that have specific subject
     *
     * @param array $ids
     * @return Builder
     */
    public function subjects($ids)
    {
        return $this->whereHas('subjects', function($query) use ($ids)
        {
            $query->whereIn('id', $ids);
        });
    }
}
