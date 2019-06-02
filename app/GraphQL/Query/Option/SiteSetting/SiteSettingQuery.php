<?php

namespace App\GraphQL\Query\Option\SiteSetting;

use App\GraphQL\Query\MainQuery;
use App\Models\Option\SiteSetting;
use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;

class SiteSettingQuery extends MainQuery
{
    public function type()
    {
        return \GraphQL::type('site_settings');
    }

    public function args()
    {
        return [
            // 
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return SiteSetting::select('id', 'name')
            ->whereIn('name', $fields->getSelect() )
            ->get()
            ->pluck('value', 'name');
    }
}