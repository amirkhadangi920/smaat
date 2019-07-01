<?php

namespace App\GraphQL\Mutation\Option\SiteSetting;

class PostersSiteSettingMutation extends BaseSiteSettingMutation
{
    use ManageSliderTrait;
    
    public $field = 'posters';
}