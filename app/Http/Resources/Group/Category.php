<?php

namespace App\Http\Resources\Group;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{
    private $breadcrumb;

    public function __construct($category, $breadcrumb = null)
    {
        parent::__construct($category);

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
            'link'          => "/api/v1/category/{$this->slug}",
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
            })
        ];
    }

    /**
     * Recursive function for showing all the category child,
     * And run this function on all it's childs
     *
     * @param Category $category
     * @return void
     */
    public function getChilds($category)
    {
        return [
            'link'          => "/api/v1/category/{$category->slug}",
            'title'         => $category->slug,
            'logo'          => $category->logo,
            'description'   => $category->description,
            'childs'        => $this->when($category->childs ?? false, function () use($category) {
                
                return $category->childs->map( function ($child) {
                   return $this->getChilds($child); 
                });
            })
        ];
    }
}