<?php

namespace App\Domains\V1\News\Models;

use App\Domains\V1\News\Models\Traits\Attribute\PostAttribute;
use App\Domains\V1\News\Models\Traits\Method\PostMethod;
use App\Domains\V1\News\Models\Traits\Relationship\PostRelationship;
use App\Domains\V1\News\Models\Traits\Scope\PostScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post.
 */
class Post extends Model
{
    use HasFactory,
        PostAttribute,
        PostMethod,
        PostRelationship,
        PostScope;
}