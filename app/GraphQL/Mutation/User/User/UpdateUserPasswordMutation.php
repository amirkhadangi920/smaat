<?php

namespace App\GraphQL\Mutation\User\User;

use GraphQL\Type\Definition\Type;
use App\User;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Http\Requests\User\v1\PasswordResetRequest;

class UpdateUserPasswordMutation extends BaseUserMutation
{
    public function type()
    {
        return \GraphQL::type('result');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(array $args = [])
    {
        return ( new PasswordResetRequest )->rules();
    }

    public function args()
    {
        return [
            'current_password' => [
                'type' => Type::string()
            ],
            'password' => [
                'type' => Type::string()
            ],
            'password_confirmation' => [
                'type' => Type::string()
            ],
        ];
    }
   
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        if ( !\Hash::check( $args['current_password'], auth()->user()->password ) )
        {
            return [
                'status' => 400,
                'message' => 'رمز عبور فعلی معتبر نمیباشد'
            ];
        }
        
        auth()->user()->tokens()->whereName('web')->delete();

        auth()->user()->update([
            'password' => \Hash::make( $args['password'] )
        ]);

        return [
            'status' => 200,
            'message' => 'رمز عبور با موفقیت تغییر کرد'
        ];
    }
}