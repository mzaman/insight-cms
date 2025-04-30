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

        protected $fillable = ['service_name', 'api_key'];

        // This model does not need to manage timestamps manually
        public $timestamps = true;
        
        // Do not append the decrypted key automatically in JSON responses
        protected $appends = []; // No need to append decrypted_api_key

}