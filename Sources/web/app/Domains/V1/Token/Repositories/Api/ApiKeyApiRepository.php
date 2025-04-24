<?php

namespace App\Domains\V1\Token\Repositories\Api;

use App\Domains\V1\Token\Models\Key;

/**
 * Class ApiKeyApiRepository.
 * 
 * @extends \App\Repositories\BaseRepository
 * @implements ApiKeyApiRepositoryInterface
 */
class ApiKeyApiRepository extends \App\Repositories\BaseRepository implements ApiKeyApiRepositoryInterface { 

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Key $model)
    {
        $this->model = $model;
    }

    // Additional methods specific to ApiKeyApiRepository
    // New methods for the repository operations

}
