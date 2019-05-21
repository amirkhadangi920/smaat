<?php

namespace App\Helpers;

use App\User;

trait CreatorRelationship
{
    /**
     * Get the creator of the model
     * that was created this model
     *
     * @return void
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}