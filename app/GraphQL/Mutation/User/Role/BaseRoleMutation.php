<?php

namespace App\GraphQL\Mutation\User\Role;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\User\RoleProps;

class BaseRoleMutation extends MainMutation
{
    use RoleProps;
    
    protected $attributes = [
        'name' => 'RoleMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'name' => [
                'type' => Type::string()
            ],
            'display_name' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'permissions' => [
                'type' => Type::listOf( Type::int() )
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }

    /**
     * The function that get the model and run after the model was created
     *
     * @param Request $request
     * @param Model $product
     * @return void
     */
    public function afterCreate($request, $role)
    {
        $role->attachPermissions( $request->get('permissions') );        
    }

    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $product
     * @return void
     */
    public function afterUpdate($request, $role)
    {
        $role->syncPermissions( $request->get('permissions') );
    }
}