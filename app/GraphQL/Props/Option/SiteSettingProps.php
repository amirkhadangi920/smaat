<?php

namespace App\GraphQL\Props\Option;

use App\Models\Option\SiteSetting;
use App\Http\Requests\v1\Option\SiteSettingRequest;

trait SiteSettingProps
{
    /**
     * Type of this controller for use in messages
     *
     * @var string
     */
    protected $type = 'site_setting';

    /**
     * The model of this controller
     *
     * @var Model
     */
    protected $model = SiteSetting::class;

    /**
     * The request class of model for validation and authorization
     *
     * @var Request
     */
    protected $request = SiteSettingRequest::class;
}