<?php

namespace App\Domains\V1\Auth\Http\Controllers\Api;

use App\Domains\V1\Auth\Http\Requests\Api\Permission\StorePermissionRequest;
use App\Domains\V1\Auth\Http\Requests\Api\Permission\UpdatePermissionRequest;
use App\Domains\V1\Auth\Models\Permission;
use App\Domains\V1\Auth\Services\Api\PermissionApiService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PermissionApiController extends Controller
{
    protected $service;

    /**
     * Instantiate a new PermissionApiController constructor.
     *
     * @param App\Domains\V1\Auth\Services\Api\PermissionApiService $service
     */
    public function __construct(PermissionApiService $service)
    {
        // Inject the service dependency into the controller
        $this->service = $service;
        
        $this->authorizeResource(Permission::class, 'permission');
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
     * @param  StorePermissionRequest  $request
     * @return Response
     */
    public function store(StorePermissionRequest $request)
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
     * @param  Permission  $permission
     * @return Response
     */
    public function show(Permission $permission)
    {
        // Retrieve the resource ID
        $id = $permission->id;

        // Retrieve and return a specific resource
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePermissionRequest  $request
     * @param  Permission  $permission
     * @return Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
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
        $id = $permission->id;

        // Update the resource
        return $this->service->update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission  $permission
     * @return Response
     */
    public function destroy(Permission $permission)
    {
        // Add validation rules
        $rules = [
            // Add your validation rules here
        ];

        // Validate the request
        $request->validate($rules);

        // Retrieve the resource ID
        $id = $permission->id;

        // Delete the resource
        return $this->service->delete($id);
    }
}
