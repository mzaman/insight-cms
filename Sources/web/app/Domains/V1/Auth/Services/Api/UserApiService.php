<?php

namespace App\Domains\V1\Auth\Services\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Domains\V1\Auth\Repositories\Api\UserApiRepository;

class UserApiService extends \App\Services\BaseApiService implements UserApiServiceInterface
{
    protected $repository;

    public function __construct(UserApiRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index() {
        try {
            $users = $this->repository->get();
            dd($users);
            // Return success response
            return $this->setResult($users)
            ->setCode(200)
            ->setStatus(true)
            ->setMessage('Posts fetched and cached successfully.')
            ->toJson();

        } catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
         }
        // catch (Exception $e) {
        //     // Log the error and format the response
        //     Log::error('Failed to fetch posts from NewsAPI: ' . $e->getMessage());
        //     return $this->exceptionResponse($e)->toJson();
        // }
    }
    // public function index(): JsonResponse
    // {
    //     try {
    //         // Fetch users from the repository
    //         $users = $this->repository->all();

    //         // Return success response with users data
    //         return response()->json([
    //             'status' => true,
    //             'code' => 200,
    //             'message' => 'Users data fetched successfully.',
    //             'data' => $users
    //         ], 200);

    //     } catch (Exception $e) {
    //         // Log the error and return error response
    //         Log::error('Failed to fetch users data from database: ' . $e->getMessage());

    //         // Return the error response as JSON
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Failed to fetch data.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
}