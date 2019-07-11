<?php

namespace App\GraphQL\Query\Group\Subject;

use App\GraphQL\Query\Group\GroupQuery;
use App\GraphQL\Helpers\AllQuery;

class SubjectsQuery extends BaseSubjectQuery
{
    use AllQuery, GroupQuery;
}