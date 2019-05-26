<?php

namespace App\GraphQL\Type\Feature;

use App\GraphQL\Type\BaseType as Base;

class BaseType extends Base
{
    public function get_fields()
    {
        return array_merge(
            [
                'categories' => $this->relationListField('category'),
            ],
            
            $this->more_fields()
        );
    }
}