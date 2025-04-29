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
        $user = $this->repository->getByColumn($credentials['email'], 'email');

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            // If no user is found or password doesn't match
            return response()->json([
                'success' => false,
                'status' => 'Unauthorized',
                'code' => 401,
                'message' => __('Invalid email or password'),
            ], 401);
        }

        // Check if the user is already logged in (if token exists)
        try {
            $token = JWTAuth::getToken(); // Retrieve the current token from the request

            if ($token) {
                // Invalidate the old token if it exists
                JWTAuth::invalidate($token);
            }
        } catch (Exception $e) {
            // If no token is found (first login or invalid token), continue with login
        }

        // Try to create a JWT token for the authenticated user
        try {
            // Create the JWT token
            $accessToken = JWTAuth::fromUser($user);

            // Optionally, hide unnecessary properties
            $user->makeHidden(['id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'deleted_at', 'timezone', 'provider', 'provider_id']);

            // Define token expiration (optional - override as needed)
            $expiresAt = Carbon::now()->addMinutes(config('jwt.ttl', 60)); // Config TTL in minutes

            return response()->json([
                'success' => true,
                'status' => 'OK',
                'code' => 200,
                'message' => __('User logged in successfully'),
                'access_token' => $accessToken,
                'token_expires_at' => $expiresAt->toDateTimeString(),
                'token_type' => 'Bearer',
                'user' => $user, // Return the user with hidden attributes
            ], 200);
        } catch (JWTException $e) {
            // Handle exception if token generation fails
            return response()->json([
                'success' => false,
                'status' => 'Unauthorized',
                'code' => 401,
                'message' => __('Could not create token, please try again'),
            ], 401);
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
        // Get the name, email, and password from the provided array
        $credentials = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    
        // Check if the email already exists using the repository
        $existingUser = $this->repository->getByColumn($credentials['email'], 'email');
    
        if ($existingUser) {
            // If user already exists with the same email
            $response = [
                'success' => false,
                'status' => 'Conflict',
                'code' => 409,
                'message' => __('Email is already registered'),
            ];
            return response()->json($response, $response['code']);
        }
    
        // Create a new user using the repository
        try {
            // Use the repository to create the user
            $user = $this->repository->create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']), // Hash password before saving
            ]);
    
            // Create the JWT token for the new user
            $accessToken = JWTAuth::fromUser($user);
    
            // Optionally, hide unnecessary properties
            $user->makeHidden(['password', 'email_verified_at', 'created_at', 'updated_at', 'deleted_at', 'to_be_logged_out', 'last_login_at', 'last_login_ip', 'timezone', 'provider', 'provider_id']);
    
            // Define token expiration (optional - override as needed)
            $expiresAt = Carbon::now()->addMinutes(config('jwt.ttl', 60)); // Config TTL in minutes
    
            $response = [
                'success' => true,
                'status' => 'OK',
                'code' => 200,
                'message' => __('User registered successfully'),
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
     * Logout the currently authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            // Get the token from the request
            $token = JWTAuth::getToken();

            // Check if the token is valid and exists
            if ($token) {
                // Invalidate the token
                JWTAuth::invalidate($token);

                // Return success message
                return response()->json([
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Successfully logged out',
                ]);
            } else {
                // If no token is found or invalid token, return error response
                return response()->json([
                    'status' => 'error',
                    'code' => 401,
                    'message' => 'No valid token found, user is not authenticated',
                ]);
            }
        } catch (JWTException $e) {
            // If an exception occurs (e.g., invalid token), return error response
            return response()->json([
                'status' => 'error',
                'code' => 401,
                'message' => 'Failed to log out, invalid token or session',
            ]);
        }
    }

    /**
     * Refresh the JWT token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        // Try to create a JWT token for the authenticated user
        try {
            $user = JWTAuth::user();
            // Create the JWT token
            $refreshToken = Auth::refresh();

            // Optionally, hide unnecessary properties
            $user->makeHidden(['id', 'password', 'email_verified_at', 'created_at', 'updated_at', 'deleted_at',  'timezone', 'provider', 'provider_id', 'roles']);

            // Define token expiration (optional - override as needed)
            $expiresAt = Carbon::now()->addMinutes(config('jwt.ttl', 60)); // Config TTL in minutes

            $response = [
                'success' => true,
                'status' => 'OK',
                'code' => 200,
                'message' => __('Token refreshed successfully'),
                'access_token' => $refreshToken,
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
                'message' => __('Could not refresh token, please try again'),
            ];
        }

        return response()->json($response, $response['code']);
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
