<?php

namespace App\Domains\V1\Auth\Models\Traits\Relationship;
use App\Domains\V1\Auth\Models\Role;

/**
 * Trait UserRelationship.
 */
trait UserRelationship
{
    
    public function isRoleHasPermission($permission)
    {
        $role = $this->role;
        return $role ? $role->isHasPermission($permission) : false;
    }
  // public function isRoleHasPermission($permission){
  //     $role = Role::find($this->role_id);
  //     return $role->exists() ? $role->isHasPermission($permission) : false;
  // }
}
