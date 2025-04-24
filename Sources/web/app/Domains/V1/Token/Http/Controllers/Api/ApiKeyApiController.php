<?php

namespace App\Domains\V1\Token\Http\Controllers\Api;

use App\Domains\V1\Token\Http\Requests\Api\ApiKey\StoreApiKeyRequest;
use App\Domains\V1\Token\Http\Requests\Api\ApiKey\UpdateApiKeyRequest;
use App\Domains\V1\Token\Models\ApiKey;
use App\Domains\V1\Token\Services\Api\ApiKeyApiService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ApiKeyApiController extends Controller
{
    protected $service;

    /**
     * Instantiate a new ApiKeyApiController constructor.
     *
     * @param App\Domains\V1\Token\Services\Api\ApiKeyApiService $service
     */
    public function __construct(ApiKeyApiService $service)
    {
        // Inject the service dependency into the controller
        $this->service = $service;
        
        // $this->authorizeResource(ApiKey::class, 'apiKey');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Retrieve and return all resources
        return $this->service->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Add validation rules
        $rules = [
            'service_name' => 'required|string|unique:api_keys,service_name',
            'api_key' => 'required|string'
        ];

        // Validate the request
        $request->validate($rules);

        // Extract data from the request
        $data = $request->only([
            'service_name',
            'api_key'
        ]);
        // dd($data);
        // Create a new resource
        return $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  ApiKey  $apiKey
     * @return Response
     */
    public function show(ApiKey $apiKey)
    {
        // Retrieve the resource ID
        $id = $apiKey->id;

        // Retrieve and return a specific resource
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateApiKeyRequest  $request
     * @param  ApiKey  $apiKey
     * @return Response
     */
    public function update(UpdateApiKeyRequest $request, ApiKey $apiKey)
    {
        // Add validation rules
        $rules = [
            // Add your validation rules here
        ];

        // Validate the request
        $request->validate($rules);


        // Extract data from the request
        $data = $request->only([
            // Add your input names here
        ]);
        
        // Retrieve the resource ID
        $id = $apiKey->id;

        // Update the resource
        return $this->service->update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ApiKey  $apiKey
     * @return Response
     */
    public function destroy(ApiKey $apiKey)
    {
        // Add validation rules
        $rules = [
            // Add your validation rules here
        ];

        // Validate the request
        $request->validate($rules);

        // Retrieve the resource ID
        $id = $apiKey->id;

        // Delete the resource
        return $this->service->delete($id);
    }
}
