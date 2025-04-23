<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface {
    public function all(){
        return User::all();
    }

    public function create(array $data){
        return User::create($data);
    }
}