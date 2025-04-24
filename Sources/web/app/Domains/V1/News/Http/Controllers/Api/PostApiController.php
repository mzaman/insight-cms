<?php

namespace App\Domains\V1\News\Http\Controllers\Api;

use App\Domains\V1\News\Http\Requests\Api\Post\StorePostRequest;
use App\Domains\V1\News\Http\Requests\Api\Post\UpdatePostRequest;
use App\Domains\V1\News\Models\Post;
use App\Domains\V1\News\Services\Api\PostApiService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PostApiController extends Controller
{
    protected $service;

    /**
     * Instantiate a new PostApiController constructor.
     *
     * @param App\Domains\V1\News\Services\Api\PostApiService $service
     */
    public function __construct(PostApiService $service)
    {
        // Inject the service dependency into the controller
        $this->service = $service;
        // $this->middleware('auth:api');
        
        // $this->authorizeResource(Post::class, 'post');
    }

    /**
     * Sync news posts from external API and store them.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function sync()
    {
        return $this->service->fetchAndStorePosts();
        // dd($result);
        // return response()->json(['message' => 'Posts synced successfully']);
    }

    /**
     * Synchronize news articles with the third-party API.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncNews(Request $request)
    {
        try {
            // Trigger the synchronization process
            $posts = $this->service->fetchAndStorePosts();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'News synchronization completed successfully.',
                'data' => $posts,
            ], 200);

        } catch (\Exception $e) {
            // Return failure response if there's an error
            return response()->json([
                'success' => false,
                'message' => 'Failed to synchronize news.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
     * @param  StorePostRequest  $request
     * @return Response
     */
    public function store(StorePostRequest $request)
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
     * @param  Post  $post
     * @return Response
     */
    public function show(Post $post)
    {
        // Retrieve the resource ID
        $id = $post->id;

        // Retrieve and return a specific resource
        return $this->service->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePostRequest  $request
     * @param  Post  $post
     * @return Response
     */
    public function update(UpdatePostRequest $request, Post $post)
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
        $id = $post->id;

        // Update the resource
        return $this->service->update($id, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return Response
     */
    public function destroy(Post $post)
    {
        // Add validation rules
        $rules = [
            // Add your validation rules here
        ];

        // Validate the request
        $request->validate($rules);

        // Retrieve the resource ID
        $id = $post->id;

        // Delete the resource
        return $this->service->delete($id);
    }
}
