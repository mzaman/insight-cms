<?php

namespace App\Domains\V1\Auth\Models\Traits\Relationship;

/**
 * Trait PermissionRelationship.
 */
trait PermissionRelationship
{
    /**
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo(__CLASS__, 'parent_id')->with('parent');
    }

    /**
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany(__CLASS__, 'parent_id')->with('children');
    }
}
