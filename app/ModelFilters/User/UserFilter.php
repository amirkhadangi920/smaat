<?php namespace App\ModelFilters\User;

use App\ModelFilters\MainFilter;
use App\ModelFilters\Query;
use App\ModelFilters\SimpleOrdering;

class UserFilter extends MainFilter
{
    use Query, SimpleOrdering;

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $search_fields = [
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * Define the search fields of this data type filter class 
     *
     * @var array
     */
    protected $ordering_items = [
        'comments'              => 'relation',
        'questionAndAnswers'    => 'relation',
        'reviews'               => 'relation',
        'orders'                => 'relation',
    ];

    /**
     * Filter the Users base on it's address
     *
     * @param string $code
     * @return Builder
     */
    public function address($id)
    {
        return $this->whereLike('address', $id);
    }

    /**
     * Filter the Users base on it's postal code
     *
     * @param string $code
     * @return Builder
     */
    public function postalCode($code)
    {
        return $this->whereLike('postal_code', $code);
    }

    /**
     * Filter the Users base on it's national code
     *
     * @param string $code
     * @return Builder
     */
    public function nationalCode($code)
    {
        return $this->whereLike('national_code', $code);
    }

    /**
     * Filter the users that locate in specific cities
     *
     * @param string $id
     * @return Builder
     */
    public function cities($ids)
    {
        return $this->filter_relation('city', $ids);
    }
}
