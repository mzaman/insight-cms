<?php

namespace App\Domains\V1\News\Models\Traits\Relationship;
use App\Domains\V1\Users\Models\User;
/**
 * Trait PostRelationship.
 */
trait PostRelationship
{
    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
