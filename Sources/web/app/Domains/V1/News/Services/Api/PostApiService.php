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
    }

    // Additional methods specific to PostApiService
    // New methods for the Api Service

    /**
     * Fetch the latest posts from the external API and store them in the database.
     * This function does not require GuzzleHttp\Client to be passed via constructor.
     * 
     * @return array|null
     */
    public function fetchAndStorePosts()
    {
        // Check if cached articles exist in Redis (to avoid fetching from API again)
        // if (Cache::has('posts')) {
        //     return Cache::get('posts');
        // }

        // Fetch posts from the third-party API (NewsAPI)
        try {
            // Using the Laravel service container to resolve GuzzleHttp client
            $client = new Client();

            // Fetch data from NewsAPI
            $apiUrl = Config::get('news.api_url') . '/' . Config::get('news.api_version') . '/top-headlines'; // Example: https://newsapi.org/v2/top-headlines';
            $apiKey = Config::get('news.api_key');
            $response = $client->get($apiUrl, [
                'query' => ['apiKey' => $apiKey, 'country' => 'us']
            ]);
            dd($response);
            // Decode the response body to extract the posts data
            $posts = json_decode($response->getBody()->getContents(), true)['articles'];

            // Loop through the fetched posts and insert or update them in the database
            foreach ($posts as $post) {
                Post::updateOrCreate(
                    ['external_id' => $post['url']],
                    [
                        'title' => $post['title'],
                        'source' => $post['source']['name'],
                        'content' => $post['content'],
                        'published_at' => $post['publishedAt'],
                        'user_id' => 1,  // Assuming admin user or dynamic user
                    ]
                );
            }

            // Cache the fetched posts for 1 hour in Redis
            Cache::put('posts', $posts, now()->addHour());

            return $posts;

        } catch (\Exception $e) {
            // Log the error for debugging and store the error details in API logs
            Log::error('Failed to fetch posts from API: ' . $e->getMessage());
            return null;
        }
    }

}
