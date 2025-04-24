<?php

namespace App\Domains\V1\Auth\Services\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Domains\V1\Auth\Repositories\Api\PermissionApiRepository;
use \Exception;

/**
 * Class PermissionApiService.
 * 
 * @extends \App\Services\BaseApiService
 * @implements PermissionApiServiceInterface
 */
class PermissionApiService extends \App\Services\BaseApiService implements PermissionApiServiceInterface { 

    /**
     * Set message api for CRUD
     * @param string $title
     * @param string $create_message
     * @param string $update_message
     * @param string $delete_message
     */
     protected $title = "";
     protected $create_message = "";
     protected $update_message = "";
     protected $delete_message = "";

     /**
     * Don't change $this->repository variable name
     * because used in extends service class
     */
     protected $repository;

    public function __construct(PermissionApiRepository $repository)
    {
      $this->repository = $repository;
    }

    // Additional methods specific to PermissionApiService
    // New methods for the Api Service
}
