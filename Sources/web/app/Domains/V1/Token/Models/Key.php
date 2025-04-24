<?php

namespace App\Domains\V1\Token\Models;

use App\Domains\V1\Token\Models\Traits\Attribute\KeyAttribute;
use App\Domains\V1\Token\Models\Traits\Method\KeyMethod;
use App\Domains\V1\Token\Models\Traits\Relationship\KeyRelationship;
use App\Domains\V1\Token\Models\Traits\Scope\KeyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Key.
 */
class Key extends Model
{
    use HasFactory,
        KeyAttribute,
        KeyMethod,
        KeyRelationship,
        KeyScope;
}