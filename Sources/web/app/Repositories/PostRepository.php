<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PostRepositoryInterface;
use App\Models\Post;

class PostRepository implements PostRepositoryInterface {
    public function all(){
        return Post::where('user_id', request()->user()->id)->get();
    }

    public function create(array $data){
        return Post::create($data);
    }

    public function delete($id){
        return Post::findOrFail($id)->delete();
    }
}