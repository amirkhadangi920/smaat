<?php

namespace App\Helpers;

trait LikeableController
{
    /**
     * Instantiate a new MainController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'only' => [ 'store', 'update', 'destroy', 'accept', 'like', 'dislike' ]
        ]);
    }
    
    /**
     * Like the given data with current logged in user
     *
     * @param [type] $data
     * @return void
     */
    public function like($data)
    {
        if ( $this->getModel($data)->liked() )
        {
            return response()->json([
                'message' => __('messages.like.before', [ 'type' => $this->type ])
            ]);
        } else {
            $this->getModel($data)->like();

            return response()->json([
                'message' => __('messages.like.successful', [ 'type' => $this->type ])
            ]);
        }
    }
    
    /**
     * Dislike the given data with current logged in user
     *
     * @param [type] $data
     * @return void
     */
    public function dislike($data)
    {   
        if ( $this->getModel($data)->disliked() )
        {
            return response()->json([
                'message' => __('messages.dislike.before', [ 'type' => $this->type ])
            ]);
        } else {
            $this->getModel($data)->dislike();

            return response()->json([
                'message' => __('messages.dislike.successful', [ 'type' => $this->type ])
            ]);
        }
    }
}