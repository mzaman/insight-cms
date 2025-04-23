<?php

namespace App\Domains\V1\Auth\Models;

use App\Domains\V1\Auth\Models\Traits\Attribute\RoleAttribute;
use App\Domains\V1\Auth\Models\Traits\Method\RoleMethod;
use App\Domains\V1\Auth\Models\Traits\Relationship\RoleRelationship;
use App\Domains\V1\Auth\Models\Traits\Scope\RoleScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role.
 */
class Role extends Model
{
    use HasFactory,
        RoleAttribute,
        RoleMethod,
        RoleRelationship,
        RoleScope;

    protected $fillable = [
        'name',
        'slug',
    ];
}