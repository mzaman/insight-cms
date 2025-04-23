<?php

namespace App\Domains\V1\News\Policies\Post;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostApiPolicy
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
