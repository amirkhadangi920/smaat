<?php

namespace App\GraphQL\Query\Option\UserSetting;

use App\GraphQL\Query\MainQuery;
use Rebing\GraphQL\Support\SselectFields;
use GraphQL\Type\Definition\ResolveInfo;
use App\Models\Option\UserSetting;

class UserSettingQuery extends MainQuery
{
    public function type()
    {
        return \GraphQL::type('user_settings');
    }

    public function args()
    {
        return [
            // 
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        return UserSetting::select('id', 'name')
            ->whereIn('name', $fields->getSelect() )
            ->get()
            ->pluck('value', 'name');
    }
}