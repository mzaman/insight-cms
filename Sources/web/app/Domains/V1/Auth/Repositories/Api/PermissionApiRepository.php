<?php

namespace App\Domains\V1\Auth\Repositories\Api;

use App\Domains\V1\Auth\Models\Permission;

/**
 * Class PermissionApiRepository.
 * 
 * @extends \App\Repositories\BaseRepository
 * @implements PermissionApiRepositoryInterface
 */
class PermissionApiRepository extends \App\Repositories\BaseRepository implements PermissionApiRepositoryInterface { 

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    // Additional methods specific to PermissionApiRepository
    // New methods for the repository operations

}
