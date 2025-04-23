<?php

namespace App\Domains\V1\Auth\Policies\User;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserApiPolicy
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
