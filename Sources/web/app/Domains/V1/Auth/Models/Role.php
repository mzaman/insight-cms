<?php

namespace App\Domains\V1\Auth\Models;

use App\Domains\V1\Auth\Models\Traits\Attribute\RoleAttribute;
use App\Domains\V1\Auth\Models\Traits\Method\RoleMethod;
use App\Domains\V1\Auth\Models\Traits\Relationship\RoleRelationship;
use App\Domains\V1\Auth\Models\Traits\Scope\RoleScope;
use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

/**
 * Class Role.
 */
class Role extends SpatieRole
{
    use HasFactory,
        RoleAttribute,
        RoleMethod,
        RoleRelationship,
        RoleScope;

    /**
     * @var string[]
     */
    protected $with = [
        'permissions',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return RoleFactory::new();
    }
}
