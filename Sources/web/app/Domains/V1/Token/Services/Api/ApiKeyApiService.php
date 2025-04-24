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
        // Check if the service name already exists in the database
        $existingApiKey = $this->repository->getByColumn($data['service_name'], 'service_name');
        
        if ($existingApiKey) {
          $this->setResult($data)
              ->setCode(404)
              ->setStatus(false)
              ->setMessage('Service name already exists. Please choose a different service name.')
              ->toJson();
        }

        // Encrypt the API key and set timestamps
        $data['api_key'] = Crypt::encryptString($data['api_key']);
        $data['created_at'] = now();

        try {
            // Create the API key in the repository
            $this->repository->create($data);

            // Return success response
            return $this->setResult($data)
            ->setCode(200)
            ->setStatus(true)
            ->setMessage('API key stored successfully.')
            ->toJson();

        } catch (QueryException $e) {
            // Catch any query-related exceptions
            \Log::error('Failed to store API key: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Database error occurred while storing the API key.'
            ], 500); // 500 Internal Server Error

        } catch (Exception $e) {
            // Catch general exceptions
            \Log::error('Failed to store API key: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while storing the API key.'
            ], 500); // 500 Internal Server Error
        }
    }
    
}
