<?php

namespace App\Domains\V1\Token\Policies\ApiKey;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApiKeyApiPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
