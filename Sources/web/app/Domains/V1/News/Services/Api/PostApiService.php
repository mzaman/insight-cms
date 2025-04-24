<?php

namespace App\Domains\V1\News\Services\Api;

use App\Domains\V1\News\Repositories\Api\PostApiRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Domains\V1\Auth\Models\User;  // For accessing CLI user if needed
use \Exception;

class PostApiService extends \App\Services\BaseApiService implements PostApiServiceInterface
{
    /**
     * Set message api for CRUD
     * @param string $title
     * @param string $create_message
     * @param string $update_message
     * @param string $delete_message
     */
    protected $title = "Post";
    protected $create_message = "created successfully";
    protected $update_message = "updated successfully";
    protected $delete_message = "deleted successfully";

    /**
     * Don't change $this->repository variable name
     * because used in extends service class
     */
    protected $repository;

    public function __construct(PostApiRepository $repository)
    {
        $this->repository = $repository;
    }

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
                ->setMessage('Posts fetched from cache.')
                ->setStatus(true)
                ->toJson();
        }

        // Detect if sync is initiated via CLI and set the user ID accordingly
        $isCli = php_sapi_name() == 'cli';
        $userId = $isCli ? $this->getCliUserId() : Auth::id(); // Use CLI User if it's a CLI sync, else use authenticated user.

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
                    'user_id' => $userId,  // Use the correct user_id (CLI or Authenticated user)
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

    /**
     * Get the CLI User ID.
     * 
     * @return int
     */
    protected function getCliUserId()
    {
        // Retrieve the CLI User by email or a predefined user for synchronization
        $cliUser = User::where('email', 'cliuser@mail.com')->first();
        return $cliUser ? $cliUser->id : 1; // Default to user ID 1 if no CLI user is found
    }
}