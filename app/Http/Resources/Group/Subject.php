<?php

namespace App\Http\Resources\Group;

use Illuminate\Http\Resources\Json\JsonResource;

class Subject extends JsonResource
{
    private $breadcrumb;

    public function __construct($subject, $breadcrumb = null)
    {
        parent::__construct($subject);

        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'link'          => "/api/v1/category/{$this->id}",
            'title'         => $this->title,
            'logo'          => $this->logo,
            'description'   => $this->description,
            'breadcrumb'    => $this->when( ($this->breadcrumb), function () {
                return $this->breadcrumb;
            }),
            'childs'        => $this->whenLoaded('childs', function () {
                return $this->childs->map( function ($child) {
                    return $this->getChilds($child);
                });
            }),
            'tags'          => $this->whenLoaded('tags', function () {
                return $this->tags->map( function ($tag) {
                    return [
                        'link' => "/api/v1/tag/{$tag->slug}",
                        'name' => $tag->name,
                    ];
                });
            })
        ];
    }
    
    /**
     * Recursive function for showing all the subject child,
     * And run this function on all it's childs
     *
     * @param Subject $subject
     * @return void
     */
    public function getChilds($subject)
    {
        return [
            'id'            => $subject->id,
            'link'          => "/api/v1/category/{$subject->id}",
            'title'         => $subject->title,
            'logo'          => $subject->logo,
            'description'   => $subject->description,
            'childs'        => $this->when($subject->childs ?? false, function () use($subject) {
                
                return $subject->childs->map( function ($child) {
                   return $this->getChilds($child); 
                });
            })
        ];
    }
}