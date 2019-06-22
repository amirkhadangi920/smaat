<?php

namespace App\GraphQL\Helpers;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;

trait UpdateMutation
{
    public function type()
    {   
        return \GraphQL::type( $this->type );
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(array $args)
    {
        return $this->checkPermission("update-". ($this->permission_label ? $this->permission_label : $this->type));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(array $args = [])
    {
        return ( new $this->request )->rules($args, 'UPDATE');
    }
    
    public function attributes()
    {
        return ( new $this->request )->attributes();
    }

    public function args()
    {
        return array_merge($this->getArgs(), [
            'id'    => [
                'type' => Type::nonNull( $this->incrementing ? Type::int() : Type::string() )
            ]
        ]);
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return $this->update($args, $fields);
    }
}