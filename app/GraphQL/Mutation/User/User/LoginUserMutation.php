<?php

namespace App\GraphQL\Mutation\User\User;

use GraphQL\Type\Definition\Type;
use App\Http\Requests\v1\LoginRequest;
use Auth;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;

class LoginUserMutation extends BaseUserMutation
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
        return ( new LoginRequest )->rules($args);
    }

    public function args()
    {
        return [
            'email'     => [
                'type' => Type::string()
            ],
            'password'  => [
                'type' => Type::string()
            ]
        ];
    }
   
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        if ( Auth::attempt([
            'email' => $args['email'], 
            'password' => $args['password']
        ]) )
        {
            Auth::user()->tokens()->whereName('web')->delete();

            return [
                'id'    => Auth::user()->id,
                'email' => Auth::user()->email,
                'token' => Auth::user()->createToken('web')->accessToken
            ];
        } 
        else
            return response()->json(['message' => 'Unauthorised'], 401);
    }
}