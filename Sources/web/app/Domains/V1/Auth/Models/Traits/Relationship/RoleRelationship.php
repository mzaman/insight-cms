<?php

namespace App\Domains\V1\Auth\Models\Traits\Relationship;

use App\Domains\V1\Auth\Models\Permission;

/**
 * Trait RoleRelationship.
 */
trait RoleRelationship
{
 
  public function isHasPermission($permission){
      $hasPermission = $this->belongsToMany(Permission::class)->where('slug', $permission)->exists();
      return $hasPermission;
  } 
}
