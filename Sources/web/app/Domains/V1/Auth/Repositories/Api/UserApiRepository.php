<?php

namespace App\Domains\V1\Auth\Repositories\Api;

use App\Domains\Auth\Models\User;

/**
 * Class UserApiRepository.
 * 
 * @extends \App\Repositories\BaseRepository
 * @implements UserApiRepositoryInterface
 */
class UserApiRepository extends \App\Repositories\BaseRepository implements UserApiRepositoryInterface { 

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    // Additional methods specific to UserApiRepository
    // New methods for the repository operations

    public function get() {
        $users = $this->model->where('deleted_at', '!=', null)->get();
        dd($users);
        return json_encode( $users );
        return $users;
    }

}
