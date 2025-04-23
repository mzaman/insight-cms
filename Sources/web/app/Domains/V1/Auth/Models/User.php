<?php

namespace App\Domains\V1\Auth\Models;

use App\Domains\V1\Auth\Models\Traits\Attribute\UserAttribute;
use App\Domains\V1\Auth\Models\Traits\Method\UserMethod;
use App\Domains\V1\Auth\Models\Traits\Relationship\UserRelationship;
use App\Domains\V1\Auth\Models\Traits\Scope\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User.
 */
class User extends Model
{
    use HasFactory,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope;
}