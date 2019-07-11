<?php

namespace App\GraphQL\Mutation\User\UserAddress;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\User\UserAddressProps;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class BaseUserAddressMutation extends MainMutation
{
    use UserAddressProps;
    
    protected $attributes = [
        'name' => 'UserAddressMutation',
        'description' => 'A mutation'
    ];

    public function getArgs()
    {
        return [
            'city_id' => [
                'type' => Type::int()
            ],
            'full_name' => [
                'type' => Type::string()
            ],
            'phone_number' => [
                'type' => Type::string()
            ],
            'type' => [
                'type' => Type::string()
            ],
            'address' => [
                'type' => Type::string()
            ],
            'postal_code' => [
                'type' => Type::string()
            ],
            'lat' => [
                'type' => Type::float()
            ],
            'lng' => [
                'type' => Type::float()
            ],
        ];
    }

    /**
     * Get the portion of request class
     *
     * @param Request $request
     * @return Array $request
     */
    public function getRequest( $request)
    {
        return array_merge( $request->all(), [
            'coordinates'   => new Point( $request->get('lat'), $request->get('lng') )
        ]);
    }
}