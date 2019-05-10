<?php

namespace App\Http\Resources\Group;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Group\Subject;

class SubjectCollection extends ResourceCollection
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
                'total' => Subject::count(),
                'trash' => Subject::onlyTrashed()->count()
            ],
            'chart' => Subject::create_timeline()
        ];
    }
}
