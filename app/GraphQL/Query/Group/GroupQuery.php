<?php

namespace App\GraphQL\Query\Group;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;

trait GroupQuery
{
    public function type()
    {
        return Type::listOf( \GraphQL::type( $this->type ) );
    }

    public function args()
    {
        return [
            // 'query' => [
            //     'type' => Type::string()
            // ],
            // 'ids' => [
            //     'type' => Type::listOf( $this->incrementing ? Type::int() : Type::string() )
            // ]
        ];
    }

    
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return $this->getAllData($args, $fields);
    }

    /**
     * Get all data of the model,
     * used by index method controller
     *
     * @return Collection
     */
    public function getAllData($args, $fields)
    {
        $data = $this->model::where('parent_id', null);

        if ( $args['ids'] ?? false )
            $data->whereIn('id', $args['ids']);
            
        $this->showOnlyAtiveData($data);

        return $data->with( $fields->getRelations() )
            ->select( $fields->getSelect() )
            ->get();
    }
}