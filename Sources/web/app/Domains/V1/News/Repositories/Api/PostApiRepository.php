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

    // Additional methods specific to PostApiRepository
    // New methods for the repository operations

}
