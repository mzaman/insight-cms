<?php

namespace App\Domains\V1\Auth\Policies\Role;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoleApiPolicy
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
