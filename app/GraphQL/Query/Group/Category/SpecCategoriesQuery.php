<?php

namespace App\GraphQL\Query\Group\Category;

use App\GraphQL\Query\Group\GroupQuery;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;

class SpecCategoriesQuery extends BaseCategoryQuery
{
    use GroupQuery;

    public function type()
    {
        return Type::listOf( \GraphQL::type('category') );
    }

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