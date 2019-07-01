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
        $options = SiteSetting::select('id', 'name')
            ->whereIn('name', $fields->getSelect() )
            ->with('media:id,model_type,model_id,file_name')
            ->get();

            
        return $options->whereIn('name', [
            'title', 'description', 'phone', 'address', 'theme_color', 'banner_link', 'is_enabled'
        ])
        ->pluck('value', 'name')
        ->merge(
            $options->whereIn('name', [ 'logo', 'watermark', 'banner', 'header_banner' ])
            ->pluck('media', 'name')
        )
        ->merge(
            $options->whereIn('name', [ 'slider', 'posters' ])
            ->keyBy('name')
        );
    }
}