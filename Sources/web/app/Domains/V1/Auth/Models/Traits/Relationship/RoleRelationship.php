<?php

namespace App\Domains\V1\Auth\Models\Traits\Relationship;

use App\Domains\V1\Auth\Models\Permission;

/**
 * Trait RoleRelationship.
 */
trait RoleRelationship
{
  public function permissions()
  {
      return $this->belongsToMany(Permission::class);
  }

  public function isHasPermission($permission)
  {
      // Check if the permission exists within the role's permissions
      return $this->permissions()->where('slug', $permission)->exists();
  }
  
//   public function isHasPermission($permission){
//       $hasPermission = $this->belongsToMany(Permission::class)->where('slug', $permission)->exists();
//       return $hasPermission;
//   } 
}
