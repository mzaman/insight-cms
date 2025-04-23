<?php

namespace App\Domains\V1\Auth\Http\Controllers\Api;

use App\Domains\V1\Auth\Http\Requests\Api\Role\StoreRoleRequest;
use App\Domains\V1\Auth\Http\Requests\Api\Role\UpdateRoleRequest;
use App\Domains\V1\Auth\Models\Role;
use App\Domains\V1\Auth\Services\Api\RoleApiService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class RoleApiController extends Controller
{
    protected $service;

    /**
     * Instantiate a new RoleApiController constructor.
     *
     * @param App\Domains\V1\Auth\Services\Api\RoleApiService $service
     */
    public function __construct(RoleApiService $service)
    {
        // Inject the service dependency into the controller
        $this->service = $service;
        
        $this->authorizeResource(Role::class, 'role');
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
     * @param  StoreRoleRequest  $request
     * @return Response
     */
    public function store(StoreRoleRequest $request)
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
     * @param  Role  $role
     * @return Response
     */
    public function show(Role $role)
    {
        // Retrieve the resource ID
        $id = $role->id;

        // Retrieve and return a specific resource
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRoleRequest  $request
     * @param  Role  $role
     * @return Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
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
        $id = $role->id;

        // Update the resource
        return $this->service->update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return Response
     */
    public function destroy(Role $role)
    {
        // Add validation rules
        $rules = [
            // Add your validation rules here
        ];

        // Validate the request
        $request->validate($rules);

        // Retrieve the resource ID
        $id = $role->id;

        // Delete the resource
        return $this->service->delete($id);
    }
}
