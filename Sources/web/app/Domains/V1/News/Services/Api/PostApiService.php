<?php

namespace App\Domains\V1\News\Services\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Domains\V1\News\Repositories\Api\PostApiRepository;
use \Exception;
use App\Domains\V1\News\Models\Post;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Class PostApiService.
 * 
 * @extends \App\Services\BaseApiService
 * @implements PostApiServiceInterface
 */
class PostApiService extends \App\Services\BaseApiService implements PostApiServiceInterface { 

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

    public function __construct(PostApiRepository $repository)
    {
      $this->repository = $repository;
      $this->title = 'Post';
      $this->create_message = 'created successfully';
      $this->update_message = 'updated successfully';
      $this->delete_message = 'deleted successfully';
    }

    // Additional methods specific to PostApiService
    // New methods for the Api Service
    /**
     * Fetch the latest posts from the external API and store them in the database.
     *
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function fetchAndStorePosts()
    {
        // Check if cached articles exist to avoid fetching again from API
        if (Cache::has('posts')) {
            return $this->setResult(Cache::get('posts'))
                        ->setCode(200)
                        ->setStatus(true)
                        ->toJson();
        }

        try {
            // Use GuzzleHttp client to fetch data from NewsAPI
            $client = new Client();
            $apiUrl = \Config::get('news.api_base_url') . '/' . \Config::get('news.api_version') . '/top-headlines';
            $apiKey = \Config::get('news.api_key');

            $response = $client->get($apiUrl, [
                'query' => ['apiKey' => $apiKey, 'country' => 'us']
            ]);

            // Decode the API response
            $posts = json_decode($response->getBody()->getContents(), true)['articles'];

            // Prepare the data for insertion with timestamps
            $postData = [];
            foreach ($posts as $post) {
                $postData[] = [
                    'title' => $post['title'],
                    'source' => $post['source']['name'],
                    'content' => $post['content'],
                    'published_at' => $post['publishedAt'],
                    'external_id' => $post['url'],
                    'user_id' => auth()->user()->id, // Assuming the current user is the admin/editor
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Use repository method to upsert the posts (either create or update)
            $this->repository->upsert($postData);

            // Cache the fetched posts for 1 hour
            Cache::put('posts', $posts, now()->addHour());

            // Return success response
            return $this->setResult($posts)
                        ->setCode(200)
                        ->setStatus(true)
                        ->setMessage('Posts fetched and stored successfully.')
                        ->toJson();

        } catch (Exception $e) {
            // Log the error and format the response
            Log::error('Failed to fetch posts from NewsAPI: ' . $e->getMessage());
            return $this->exceptionResponse($e)->toJson();
        }
    }

}
