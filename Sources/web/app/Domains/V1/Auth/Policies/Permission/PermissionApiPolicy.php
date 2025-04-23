<?php

namespace App\Domains\V1\Auth\Policies\Permission;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionApiPolicy
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
