<?php

namespace App\Http\Requests\v1\Option;

use App\Http\Requests\v1\MainRequest;

class SiteSettingRequest extends MainRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($args, $method)
    {
        $this->method = $method;

        return [
            'title'                 => 'filled|string|max:50',
            'description'           => 'nullable|string|max:250',
            'phone'                 => [
                'nullable',
                'string',
                'regex:/^(\+98|0)?9\d{9}$/',
            ],
            'address'               => 'nullable|string|max:250',
            'theme_color'           => ['nullable', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'is_active'             => 'nullable|boolean',

            'logo'                  => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'banner'                => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'header_banner'         => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'watermark'             => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            
            'slider'                => 'nullable|array',
            'slider.*'              => 'required|array',
            'slider.*.image'        => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'slider.*.title'        => 'nullable|string|max:50',
            'slider.*.description'  => 'nullable|string|max:100',
            'slider.*.button'       => 'nullable|string|max:20',
            'slider.*.link'         => 'nullable|url|max:200',
            
            'posters'               => 'nullable|array',
            'posters.*'             => 'required|array',
            'posters.*.image'       => 'nullable|image|mimes:jpeg,jpg,png,gif|max:1024',
            'posters.*.title'       => 'nullable|string|max:50',
            'posters.*.description' => 'nullable|string|max:100',
            'posters.*.button'      => 'nullable|string|max:20',
            'posters.*.link'        => 'nullable|url|max:200',
        ];
    }
}
