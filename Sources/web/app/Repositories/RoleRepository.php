<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Role;
use App\Models\Permission;

class RoleRepository implements RoleRepositoryInterface {
    public function all(){
        return Role::all();
    }

    public function create(array $data){
        return Role::create($data);
    }

    public function find($id){
        return Role::findOrFail($id);
    }

    public function permissions(Role $role){
        return $role->belongsToMany(Permission::class);
    }
}