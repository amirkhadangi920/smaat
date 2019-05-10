<?php

namespace App\Http\Resources\Spec;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Spec\Spec;

class SpecCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'trash' => Spec::onlyTrashed()->count()
            ],
            'chart' => Spec::create_timeline()
        ];
    }
}
