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
            'registered_at'     => $this->created_at,
            'votes'             => [
                'likes' => $this->likesCount,
                'dislikes' => $this->dislikesCount,
            ],
            'article'           => $this->whenLoaded('article', function () {
                return [
                    'id' => $this->article->id,
                    'link' => "/api/v1/article/{$this->article->slug}",
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
                        'registered_at'     => $answer->created_at,
                        'writer'            => $this->whenLoaded('user', function () use ($answer) {
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
