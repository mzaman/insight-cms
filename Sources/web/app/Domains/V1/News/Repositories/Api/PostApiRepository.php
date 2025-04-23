<?php

namespace App\Domains\V1\News\Repositories\Api;

use App\Domains\V1\News\Models\Post;

/**
 * Class PostApiRepository.
 * 
 * @extends \App\Repositories\BaseRepository
 * @implements PostApiRepositoryInterface
 */
class PostApiRepository extends \App\Repositories\BaseRepository implements PostApiRepositoryInterface { 

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected $model;

    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * Insert or update multiple records using updateOrCreate.
     *
     * @param array $data
     * @return array
     */
    public function upsert(array $data)
    {
        $updatedOrCreatedPosts = [];

        foreach ($data as $item) {
            // Using updateOrCreate to either update or create a post by external_id
            $post = $this->model->updateOrCreate(
                ['external_id' => $item['external_id']], // Match by external_id
                [
                    'title' => $item['title'],
                    'source' => $item['source'],
                    'content' => $item['content'],
                    'published_at' => $item['published_at'],
                    'user_id' => $item['user_id'], // Assuming user_id is part of the data
                    'updated_at' => now(), // Ensure `updated_at` is updated on every `updateOrCreate`
                ]
            );

            // Add the updated or created post to the result array
            $updatedOrCreatedPosts[] = $post;
        }

        // Return the newly created or updated posts
        return $updatedOrCreatedPosts;
    }

    /**
     * Insert or update multiple records.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Collection
     */
    // public function upsert(array $data)
    // {
    //     // Use upsert to insert or update posts by external_id
    //     // 'external_id' will act as the unique key for checking if the post already exists
    //     $this->model->upsert($data, ['external_id'], ['title', 'source', 'content', 'published_at', 'updated_at']);

    //     return $this->model->all();
    // }
    // Additional methods specific to PostApiRepository
    // New methods for the repository operations

}
