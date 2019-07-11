<?php

namespace App\GraphQL\Query\Group\Subject;

use App\GraphQL\Query\MainQuery;
use App\GraphQL\Props\Group\SubjectProps;

class BaseSubjectQuery extends MainQuery
{
    use SubjectProps;
    
    protected $translatable = true;
}