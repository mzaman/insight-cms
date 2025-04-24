<?php

namespace App\Domains\V1\Token\Models;

use App\Domains\V1\Token\Models\Traits\Attribute\ApiKeyAttribute;
use App\Domains\V1\Token\Models\Traits\Method\ApiKeyMethod;
use App\Domains\V1\Token\Models\Traits\Relationship\ApiKeyRelationship;
use App\Domains\V1\Token\Models\Traits\Scope\ApiKeyScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApiKey.
 */
class ApiKey extends Model
{
    use HasFactory,
        ApiKeyAttribute,
        ApiKeyMethod,
        ApiKeyRelationship,
        ApiKeyScope;
}