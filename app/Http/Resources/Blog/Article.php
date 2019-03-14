<?php

namespace App\Http\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'              => $this->id,
            'link'              => "/api/v1/article/{$this->slug}",
            'title'             => $this->title,
            'description'       => $this->description,
            'body'              => $this->when( $this->body, $this->body ),
            'image'             => $this->image,
            'reading_time'      => $this->reading_time,
            'votes'             => [
                'likes' => $this->likesCount,
                'dislikes' => $this->dislikesCount,
            ],
            'writer'            => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'fullname' => $this->user->full_name,
                ];
            }),
            'subjects'          => $this->subjects->map( function ( $subject ) {
                
                return [
                    'id'    => $subject->id,
                    'link'  => "/api/v1/category/{$subject->slug}",
                    'title' => $subject->title,
                ];
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
}
