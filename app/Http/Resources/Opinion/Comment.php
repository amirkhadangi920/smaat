<?php

namespace App\Http\Resources\Opinion;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'link'              => "/api/v1/comment/{$this->id}",
            'message'           => $this->message,
            'create_time'       => $this->getOriginal('created_at'),
            'last_update_time'  => $this->getOriginal('updated_at'),
            'is_accept'         => $this->is_accept,
            'votes'             => [
                'likes' => $this->likesCount,
                'dislikes' => $this->dislikesCount,
            ],
            'article'           => $this->whenLoaded('article', function () {
                return [
                    'id' => $this->article->id,
                    'link' => "/api/v1/article/{$this->article->slug}",
                    'image' => $this->article->image,
                    'title' => $this->article->title
                ];
            }),
            'writer'            => $this->whenLoaded('user', function () {
                return [
                    'id' => $this->user->id,
                    'full_name' => $this->user->full_name,
                    'avatar' => $this->user->avatar
                ];
            }),
            'answers'           => $this->whenLoaded('answers', function () {
                return $this->answers->map( function ( $answer ) {
                    return [
                        'id'                => $answer->id,
                        'link'              => "/api/v1/comment/{$answer->id}",
                        'message'           => $answer->message,
                        'is_accept'         => $answer->is_accept,
                        'create_time'       => $answer->getOriginal('created_at'),
                        'last_update_time'  => $answer->getOriginal('updated_at'),
                        'writer'            => $this->when($answer->user, function () use ($answer) {
                            return [
                                'id' => $answer->user->id,
                                'full_name' => $answer->user->full_name,
                                'avatar' => $answer->user->avatar
                            ];
                        }),
                    ];
                });
            }),
        ];
    }
}
