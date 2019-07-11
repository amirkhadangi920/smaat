<?php

namespace App\GraphQL\Mutation\Option\SiteSetting;

class SliderSiteSettingMutation extends BaseSiteSettingMutation
{
    use ManageSliderTrait;
    
    public $field = 'slider';
}