<?php

namespace App\Domains\V1\Auth\Http\Controllers\Api;

use App\Domains\V1\Auth\Http\Requests\Api\User\StoreUserRequest;
use App\Domains\V1\Auth\Http\Requests\Api\User\UpdateUserRequest;
use App\Domains\V1\Auth\Models\User;
use App\Domains\V1\Auth\Services\Api\UserApiService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    protected $service;

    /**
     * Instantiate a new UserApiController constructor.
     *
     * @param App\Domains\V1\Auth\Services\Api\UserApiService $service
     */
    public function __construct(UserApiService $service)
    {
        // Inject the service dependency into the controller
        $this->service = $service;
        
        $this->authorizeResource(User::class, 'user');
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
     * @param  StoreUserRequest  $request
     * @return Response
     */
    public function store(StoreUserRequest $request)
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
     * @param  User  $user
     * @return Response
     */
    public function show(User $user)
    {
        // Retrieve the resource ID
        $id = $user->id;

        // Retrieve and return a specific resource
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  User  $user
     * @return Response
     */
    public function update(UpdateUserRequest $request, User $user)
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
        $id = $user->id;

        // Update the resource
        return $this->service->update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return Response
     */
    public function destroy(User $user)
    {
        // Add validation rules
        $rules = [
            // Add your validation rules here
        ];

        // Validate the request
        $request->validate($rules);

        // Retrieve the resource ID
        $id = $user->id;

        // Delete the resource
        return $this->service->delete($id);
    }
}
