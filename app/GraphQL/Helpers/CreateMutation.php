<?php

namespace App\GraphQL\Helpers;

use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;

trait CreateMutation
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
        return $this->checkPermission("create-{$this->name}");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(array $args = [])
    {
        return ( new $this->request )->rules();
    }

    public function args()
    {
        return $this->getArgs();
    }
   
    
    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return $this->store($args, $fields);
    }
}