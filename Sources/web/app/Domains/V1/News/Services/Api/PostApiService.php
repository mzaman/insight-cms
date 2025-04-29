<?php

namespace App\Domains\V1\News\Services\Api;

use App\Domains\V1\News\Repositories\Api\PostApiRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use \Exception;
use App\Domains\V1\News\Traits\NewsFetcher;

class PostApiService extends \App\Services\BaseApiService implements PostApiServiceInterface
{
    use NewsFetcher;
    
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
        if (Cache::has('posts')) {
            return $this->setResult(Cache::get('posts'))
                ->setCode(200)
                ->setMessage('Posts fetched from cache.')
                ->setStatus(true)
                ->toJson();
        }

        $userId = $this->resolveSyncUserId();

        try {
            $apiKey = $this->getDecryptedApiKey();

            $apiUrl = config('news.api_base_url') . '/' . config('news.api_version') . '/top-headlines';

            $apiData = $this->fetchFromApi($apiUrl, [
                'apiKey' => $apiKey,
                'country' => 'us',
            ]);

            $articles = $apiData['articles'] ?? [];

            // Prepare data (still service-specific)
            $postData = collect($articles)->map(function ($post) use ($userId) {
                return [
                    'title' => $post['title'],
                    'source' => $post['source']['name'],
                    'content' => $post['content'],
                    'published_at' => $post['publishedAt'],
                    'external_id' => $post['url'],
                    'user_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            $this->repository->upsert($postData);
            Cache::put('posts', $articles, now()->addHour());

            return $this->setResult($articles)
                ->setCode(200)
                ->setStatus(true)
                ->setMessage('Posts fetched and cached successfully.')
                ->toJson();

        } catch (Exception $e) {
            return $this->exceptionResponse($e)->toJson();
        }
    }

}