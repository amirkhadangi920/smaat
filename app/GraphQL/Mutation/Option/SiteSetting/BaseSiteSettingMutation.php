<?php

namespace App\GraphQL\Mutation\Option\SiteSetting;

use GraphQL\Type\Definition\Type;
use App\GraphQL\Mutation\MainMutation;
use App\GraphQL\Props\Option\SiteSettingProps;
use Rebing\GraphQL\Support\UploadType;

class BaseSiteSettingMutation extends MainMutation
{
    use SiteSettingProps;
    
    protected $attributes = [
        'name' => 'SiteSettingMutation',
        'description' => 'A mutation'
    ];
    
    public function type()
    {   
        return \GraphQL::type('result');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(array $args)
    {
        return $this->checkPermission("update-setting");
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
}