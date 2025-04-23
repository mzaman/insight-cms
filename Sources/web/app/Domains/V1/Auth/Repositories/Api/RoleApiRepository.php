<?php

namespace App\Domains\V1\Auth\Repositories\Api;

use App\Domains\V1\Auth\Models\Role;

/**
 * Class RoleApiRepository.
 * 
 * @extends \App\Repositories\BaseRepository
 * @implements RoleApiRepositoryInterface
 */
class RoleApiRepository extends \App\Repositories\BaseRepository implements RoleApiRepositoryInterface { 

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    // Additional methods specific to RoleApiRepository
    // New methods for the repository operations

}
