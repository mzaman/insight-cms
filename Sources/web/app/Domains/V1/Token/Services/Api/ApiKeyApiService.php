<?php

namespace App\Domains\V1\Token\Services\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Domains\V1\Token\Repositories\Api\ApiKeyApiRepository;
use \Exception;

/**
 * Class ApiKeyApiService.
 * 
 * @extends \App\Services\BaseApiService
 * @implements ApiKeyApiServiceInterface
 */
class ApiKeyApiService extends \App\Services\BaseApiService implements ApiKeyApiServiceInterface { 

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

    public function __construct(ApiKeyApiRepository $repository)
    {
      $this->repository = $repository;
    }

    // Additional methods specific to ApiKeyApiService
    // New methods for the Api Service
}
