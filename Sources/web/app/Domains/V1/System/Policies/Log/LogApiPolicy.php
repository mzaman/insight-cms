<?php

namespace App\Domains\V1\System\Policies\Log;

use App\Domains\Auth\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogApiPolicy
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
