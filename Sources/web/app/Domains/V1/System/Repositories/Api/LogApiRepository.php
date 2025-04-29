<?php

namespace App\Domains\V1\System\Repositories\Api;

use App\Domains\V1\System\Models\Log;

/**
 * Class LogApiRepository.
 * 
 * @extends \App\Repositories\BaseRepository
 * @implements LogApiRepositoryInterface
 */
class LogApiRepository extends \App\Repositories\BaseRepository implements LogApiRepositoryInterface { 

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Log $model)
    {
        $this->model = $model;
    }

    // Additional methods specific to LogApiRepository
    // New methods for the repository operations

}
