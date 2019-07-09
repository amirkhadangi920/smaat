<?php

namespace App\GraphQL\Mutation\User\User;

use GraphQL\Type\Definition\Type;
use App\Http\Requests\v1\RegisterRequest;
use App\User;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\UploadType;

class RegisterUserMutation extends BaseUserMutation
{
    public function type()
    {
        return \GraphQL::type('me');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(array $args = [])
    {
        return ( new RegisterRequest )->rules($args, 'REGISTER');
    }

    public function args()
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
            'national_code' => [
                'type' => Type::string()
            ],
            'gender' => [
                'type' => Type::boolean()
            ],
        ];
    }
   
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $user = User::create(array_merge(
            $this->getRequest( collect( $args ) ), [
                'password' => bcrypt( $args['password'] )
            ]
        ));

        auth()->login( $user );

        $this->moveLocalCartToServer();

        $data = collect( $user->toArray() );
            
        $data->put('token', $user->createToken('web')->accessToken);

        return $data;
    }
}