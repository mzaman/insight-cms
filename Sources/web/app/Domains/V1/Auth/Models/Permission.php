<?php

namespace App\Domains\V1\Auth\Models;

use App\Domains\V1\Auth\Models\Traits\Attribute\PermissionAttribute;
use App\Domains\V1\Auth\Models\Traits\Method\PermissionMethod;
use App\Domains\V1\Auth\Models\Traits\Relationship\PermissionRelationship;
use App\Domains\V1\Auth\Models\Traits\Scope\PermissionScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission.
 */
class Permission extends Model
{
    use HasFactory,
        PermissionAttribute,
        PermissionMethod,
        PermissionRelationship,
        PermissionScope;
        
    protected $fillable = [
        'name',
        'slug',
    ];
}