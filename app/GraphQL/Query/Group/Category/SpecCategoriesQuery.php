<?php

namespace App\GraphQL\Query\Group\Category;

use App\GraphQL\Query\Group\GroupQuery;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;

class SpecCategoriesQuery extends BaseCategoryQuery
{
    use GroupQuery;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(array $args)
    {
        return $this->checkPermission("read-spec");
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return $this->model::whereHas('spec')
            ->with( $fields->getRelations() )
            ->select( $fields->getSelect() )
            ->get();
    }
}