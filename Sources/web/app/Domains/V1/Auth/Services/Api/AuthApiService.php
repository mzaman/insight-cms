<?php

namespace App\Domains\V1\Auth\Services\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Domains\V1\Auth\Repositories\Api\UserApiRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Exception;

/**
 * Class AuthApiService.
 * 
 * @extends \App\Services\BaseApiService
 * @implements UserApiServiceInterface
 */
class AuthApiService extends \App\Services\BaseApiService implements UserApiServiceInterface { 

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

    public function __construct(UserApiRepository $repository)
    {
      $this->repository = $repository;
    }

    // Additional methods specific to UserApiService
    // New methods for the Api Service
    
    /**
     * Login user.
     * 
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function login(array $data)
    {
        try {
            // Logout if the user is already logged in
            if (Auth::check()) {
                Auth::logout();
            }

            // Attempt to login
            $token = Auth::attempt($data);
            
            // Check if token was generated
            if ($token) {
                $user = Auth::user()->makeHidden([
                    'id',                 // Exclude id field
                    'email_verified_at', // Exclude email_verified_at field
                    'created_at',         // Exclude created_at field
                    'updated_at',         // Exclude updated_at field
                    'deleted_at'          // Exclude deleted_at field
                ]);

                // Return user with token
                return $this->responseWith($user, $token);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 401);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Register a new user.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function register($data)
    {
        // Logout if the user is already logged in
        if (Auth::check()) {
            Auth::logout();
        }

        try {
            // Create a new user
            $user = $this->repository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'password' => Hash::make($data['password']),
            ]);

            // Generate a token for the user
            $token = Auth::login($user);
            $user->makeHidden([
                'id',                 // Exclude id field
                'email_verified_at', // Exclude email_verified_at field
                'created_at',         // Exclude created_at field
                'updated_at',         // Exclude updated_at field
                'deleted_at'          // Exclude deleted_at field
            ]);
            // Return the response with user and token
            return $this->responseWith($user, $token);

        } catch (Exception $e) {
            // Handle exception and return a relevant message
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Logout the currently authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        // Logout the user
        Auth::logout();

        // Return success message
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Refresh the JWT token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // Refresh the token and return user data with the new token
        return $this->responseWith(Auth::user(), Auth::refresh());
    }

    /**
     * Generate response with user data and token.
     *
     * @param mixed $user
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseWith($user, string $token)
    {
        // Construct the response array
        $responseArr = [
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];

        // Return the JSON response
        return response()->json($responseArr);
    }
}
