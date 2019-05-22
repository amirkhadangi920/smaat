<?php

namespace App\GraphQL\Mutation\User\User;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\User\UserProps;
use Rebing\GraphQL\Support\UploadType;

class BaseUserMutation extends MainMutation
{
    use UserProps;
    
    protected $incrementing = false;
    
    protected $attributes = [
        'name' => 'UserMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'city_id' => [
                'type' => Type::int()
            ],
            'first_name' => [
                'type' => Type::string()
            ],
            'last_name' => [
                'type' => Type::string()
            ],
            'phones' => [
                'type' => Type::listOf( \GraphQL::type('data_array') )
            ],
            'social_links' => [
                'type' => Type::listOf( \GraphQL::type('data_array') )
            ],
            'email' => [
                'type' => Type::string()
            ],
            'password' => [
                'type' => Type::string()
            ],
            'password_confirmation' => [
                'type' => Type::string()
            ],
            'avatar' => [
                'type' => UploadType::getInstance()
            ],
            'address' => [
                'type' => Type::string()
            ],
            'postal_code' => [
                'type' => Type::string()
            ],
            'national_code' => [
                'type' => Type::string()
            ],
            'is_active' => [
                'type' => Type::boolean()
            ]
        ];
    }
    
    /**
     * The function that get the model and run after the model was updated
     *
     * @param Request $request
     * @param Model $product
     * @return void
     */
    public function afterUpdate($request, $user)
    {
        $user->syncPermissions( $request->get('permissions') ?? [] );
        $user->syncRoles( $request->get('roles') ?? [] );
    }
    
    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest( $request)
    {
        return $request->only(
            'city_id',
            'first_name',
            'last_name',
            'phones',
            'social_links',
            'email',
            'avatar',
            'address',
            'postal_code'
        )->all();
    }
}