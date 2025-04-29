<?php

namespace App\Domains\V1\Auth\Models;

use App\Domains\V1\Auth\Models\Traits\Attribute\UserAttribute;
use App\Domains\V1\Auth\Models\Traits\Method\UserMethod;
use App\Domains\V1\Auth\Models\Traits\Relationship\UserRelationship;
use App\Domains\V1\Auth\Models\Traits\Scope\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User.
 */
class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes,
        HasApiTokens, 
        HasRoles,
        HasFactory, 
        Notifiable,
        SoftDeletes,
        UserAttribute,
        UserMethod,
        UserRelationship,
        UserScope;

    public const TYPE_ADMIN = 'admin';

    public const TYPE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'name',
        'email',
        'email_verified_at',
        'password',
        'password_changed_at',
        'active',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'to_be_logged_out',
        'provider',
        'provider_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'password_changed_at' => 'datetime',
        'active' => 'boolean',
        'last_login_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'to_be_logged_out' => 'boolean',    ];

    /**
     * @var array
     */
    protected $appends = [
        'avatar',
    ];

    /**
     * @var string[]
     */
    protected $with = [
        'permissions',
        'roles',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
