<?php

namespace App\Http\Resources\Opinion;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionAndAnswer extends JsonResource
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
            'id'                => $this->id,
            'link'              => "/api/v1/question_and_answer/{$this->id}",
            'message'           => $this->message,
            'is_accept'         => $this->is_accept,
            'create_time'       => $this->getOriginal('created_at'),
            'last_update_time'  => $this->getOriginal('updated_at'),
            'question'          => $this->when( $this->question_id, function () {
                $this->load('question');
                
                return [
                    'id'                => $this->question->id,
                    'link'              => "/api/v1/question_and_answer/{$this->question->id}",
                    'message'           => $this->question->message,
                    'registered_at'     => $this->question->created_at,
                ];
            }),
            'product'           => $this->whenLoaded('product', function () {
                return [
                    'id' => $this->product->id,
                    'link' => "/api/v1/product/{$this->product->slug}",
                    'name' => $this->product->name,
                    'photos' => $this->product->photos,
                    'label' => $this->product->label,
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
                        'link'              => "/api/v1/question_and_answer/{$answer->id}",
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
