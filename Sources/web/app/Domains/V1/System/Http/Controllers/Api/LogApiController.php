<?php

namespace App\Domains\V1\System\Http\Controllers\Api;

use App\Domains\V1\System\Http\Requests\Api\Log\StoreLogRequest;
use App\Domains\V1\System\Http\Requests\Api\Log\UpdateLogRequest;
use App\Domains\V1\System\Models\Log;
use App\Domains\V1\System\Services\Api\LogApiService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class LogApiController extends Controller
{
    protected $service;

    /**
     * Instantiate a new LogApiController constructor.
     *
     * @param App\Domains\V1\System\Services\Api\LogApiService $service
     */
    public function __construct(LogApiService $service)
    {
        // Inject the service dependency into the controller
        $this->service = $service;
        
        // $this->authorizeResource(Log::class, 'log');
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
     * @param  StoreLogRequest  $request
     * @return Response
     */
    public function store(StoreLogRequest $request)
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

        // Create a new resource
        return $this->service->create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  Log  $log
     * @return Response
     */
    public function show(Log $log)
    {
        // Retrieve the resource ID
        $id = $log->id;

        // Retrieve and return a specific resource
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateLogRequest  $request
     * @param  Log  $log
     * @return Response
     */
    public function update(UpdateLogRequest $request, Log $log)
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
        $id = $log->id;

        // Update the resource
        return $this->service->update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Log  $log
     * @return Response
     */
    public function destroy(Log $log)
    {
        // Add validation rules
        $rules = [
            // Add your validation rules here
        ];

        // Validate the request
        $request->validate($rules);

        // Retrieve the resource ID
        $id = $log->id;

        // Delete the resource
        return $this->service->delete($id);
    }
}
