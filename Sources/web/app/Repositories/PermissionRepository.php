<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface {
    public function all(){
        return Permission::all();
    }

    public function create(array $data){
        return Permission::create($data);
    }
}