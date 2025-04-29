<?php

namespace App\Domains\V1\Auth\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordHistory.
 */
class PasswordHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'password_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['password'];
}
