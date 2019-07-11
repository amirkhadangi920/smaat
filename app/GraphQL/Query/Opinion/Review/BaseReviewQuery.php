<?php

namespace App\GraphQL\Query\Opinion\Review;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Opinion\ReviewProps;

class BaseReviewQuery extends MainQuery
{
    use ReviewProps;

    protected $acceptable = false;
    
    public function authorize(array $args)
    {
        return $this->checkPermission('read-review');
    }
}