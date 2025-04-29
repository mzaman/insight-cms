<?php

namespace App\Domains\V1\System\Models;

use App\Domains\V1\System\Models\Traits\Attribute\LogAttribute;
use App\Domains\V1\System\Models\Traits\Method\LogMethod;
use App\Domains\V1\System\Models\Traits\Relationship\LogRelationship;
use App\Domains\V1\System\Models\Traits\Scope\LogScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Log.
 */
class Log extends Model
{
    use HasFactory,
        LogAttribute,
        LogMethod,
        LogRelationship,
        LogScope;
}