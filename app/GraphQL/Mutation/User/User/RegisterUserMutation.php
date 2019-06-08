<?php

namespace App\GraphQL\Mutation\User\User;

use GraphQL\Type\Definition\Type;
use App\Http\Requests\v1\RegisterRequest;
use App\User;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;

class RegisterUserMutation extends BaseUserMutation
{
    public function type()
    {
        return \GraphQL::type('user');
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
            'email'                 => [
                'type' => Type::string()
            ],
            'password'              => [
                'type' => Type::string()
            ],
            'password_confirmation' => [
                'type' => Type::string()
            ],
        ];
    }
   
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $user = User::create([
            'email' => $args['email'],
            'password' => bcrypt( $args['password'] )
        ]);

        auth()->login( $user );

        $this->moveLocalCartToServer();

        return [
            'id'    => $user->id,
            'email' => $user->email,
            'token' => $user->createToken('web')->accessToken
        ];
    }
}