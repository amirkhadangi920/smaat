<?php

namespace App\GraphQL\Mutation\User\User;

use GraphQL\Type\Definition\Type;
use App\Http\Requests\v1\LoginRequest;
use Auth;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use function GuzzleHttp\json_encode;

class LoginUserMutation extends BaseUserMutation
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
        return ( new LoginRequest )->rules($args, 'LOGIN');
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

            $this->moveLocalCartToServer();

            $data = collect( Auth::user()->toArray() );
            
            $data->put('token', Auth::user()->createToken('web')->accessToken);

            return $data;
        } 
        else
        {
            die(json_encode([
                'status' => 400,
                'message' => 'Unauthorised'
            ]));
        }
    }
}