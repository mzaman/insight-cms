<?php

namespace App\Domains\V1\Token\Services\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Domains\V1\Token\Repositories\Api\ApiKeyApiRepository;
use Illuminate\Support\Facades\Crypt;
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
     protected $title = "API Key";
     protected $create_message = "created successfully";
     protected $update_message = "updated successfully";
     protected $delete_message = "deleted successfully";

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

    /**
     * Create ApiKeyApi
     * @param array $data
     * @return array
     */
    public function create($data)
    {
      $data['api_key'] = Crypt::encryptString($data['api_key']);
      dd($data);
        try {
            $this->repository->create($data);
            return $this->setResult($posts)
              ->setCode(200)
              ->setStatus(true)
              ->setMessage('API key stored successfully.')
              ->toJson();
        } catch (QueryException $e) {
            return $this->responseError($e->getMessage());
        } catch (Exception $e) {
            // Log the error and format the response
            Log::error('Failed to store API key: ' . $e->getMessage());
            return $this->exceptionResponse($e)->toJson();
        }
    }
    
}
