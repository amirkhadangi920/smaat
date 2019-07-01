<?php

namespace App\GraphQL\Mutation\Option\SiteSetting;

use Rebing\GraphQL\Support\SelectFields;
use GraphQL\Type\Definition\ResolveInfo;
use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;
use Spatie\MediaLibrary\Models\Media;
use GraphQL\Type\Definition\Type;

trait ManageSliderTrait
{
    public function args()
    {
        return [
            $this->field => [
                'type' => Type::listOf( \GraphQL::type('slider_item_input') )
            ],
        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        $args = collect($args);

        if ( !$args->get( $this->field ) )
            return $this->result(false);

        $this->updateSlider($args);

        return $this->result();
    }

    public function result($status = true)
    {
        return [
            'status' => $status ? 200 : 400,
            'message' => $status ? 'اسلایدر وبسایت با موفقیت بروزرسانی شد' : 'متاسفانه اسلایدر وبسایت هیچ تغییری نکرد'
        ];
    }

    public function updateSlider($args)
    {
        $slider = $this->model::whereName( $this->field )->first();

        if (!$slider)
            $slider = $this->model::create([ 'name' => $this->field ]);

        $slider_item = $slider->value ? collect( json_decode($slider->value, true) ) : collect([]);

        foreach ( $args->get( $this->field ) as $index => $slide )
        {
            if (!$slide) continue;

            $image = null;

            if ( $slider_item[$index] ?? false )
            {
                if ( $slide['image'] ?? false )
                {
                    if ( $slider_item[$index]['image'] ?? false )
                        Media::where('id', $slider_item[$index]['image'])->delete();
                        
                    $image = $slider->addMedia( $slide['image'] )->toMediaCollection();
                }

                $slider_item[$index] = [
                    'title' => $slide['title'] ?? $slider_item[$index]['title'] ?? null,
                    'description' => $slide['description'] ?? $slider_item[$index]['description'] ?? null,
                    'button' => $slide['button'] ?? $slider_item[$index]['button'] ?? null,
                    'link' => $slide['link'] ?? $slider_item[$index]['link'] ?? null,
                    'image' => $image->id ?? $slider_item[$index]['image'] ?? null
                ];
            }
            else
            {
                if ( $slide['image'] ?? false )
                    $image = $slider->addMedia( $slide['image'] )->toMediaCollection();

                $slider_item[$index] = [
                    'title' => $slide['title'] ?? null,
                    'description' => $slide['description'] ?? null,
                    'button' => $slide['button'] ?? null,
                    'link' => $slide['link'] ?? null,
                    'image' => $image->id ?? null
                ];
            }
        }

        $slider->update([ 'value' => json_encode($slider_item->take( count( $args->get( $this->field ) ) ), true) ]);
    }
}