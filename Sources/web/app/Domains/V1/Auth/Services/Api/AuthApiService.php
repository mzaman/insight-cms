<?php

namespace App\Domains\V1\Auth\Services\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Domains\V1\Auth\Repositories\Api\UserApiRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Exception;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use Carbon\Carbon;


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
        // Get the email and password from the provided array
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    
        // Validate credentials
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            // If no user is found or password doesn't match
            $response = [
                'success' => false,
                'status' => 'Unauthorized',
                'code' => 401,
                'message' => __('Invalid email or password'),
            ];
            return response()->json($response, $response['code']);
        }
    
        // Try to create a JWT token for the authenticated user
        try {
            // Create the JWT token
            $accessToken = JWTAuth::fromUser($user);
    
            // Optionally, hide unnecessary properties
            $user->makeHidden(['id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'deleted_at',  'timezone', 'provider', 'provider_id']);
    
            // Define token expiration (optional - override as needed)
            $expiresAt = Carbon::now()->addMinutes(config('jwt.ttl', 60)); // Config TTL in minutes
    
            $response = [
                'success' => true,
                'status' => 'OK',
                'code' => 200,
                'message' => __('User logged in successfully'),
                'access_token' => $accessToken,
                'token_expires_at' => $expiresAt->toDateTimeString(),
                'token_type' => 'Bearer',
                'user' => $user, // Return the user with hidden attributes
            ];
        } catch (JWTException $e) {
            // Handle exception if token generation fails
            $response = [
                'success' => false,
                'status' => 'Unauthorized',
                'code' => 401,
                'message' => __('Could not create token, please try again'),
            ];
        }
    
        return response()->json($response, $response['code']);
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
      try {
          // Retrieve the currently authenticated user
          $user = Auth::user();

          // Generate a new token
          $token = Auth::refresh();

          // Return the response with the new token and user details
          return $this->responseWith(
              $user->makeHidden([
                  'id',                 // Exclude id field
                  'email_verified_at',  // Exclude email_verified_at field
                  'created_at',          // Exclude created_at field
                  'updated_at',          // Exclude updated_at field
                  'deleted_at',          // Exclude deleted_at field
              ]),
              $token
          );
      } catch (Exception $e) {
          // Handle any error that occurs during refresh
          return response()->json([
              'status' => 'error',
              'message' => 'Failed to refresh token. Please try again.',
          ], 500);
      }
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
