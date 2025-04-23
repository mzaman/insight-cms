<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];


    public function isHasPermission($permission){
        $hasPermission = $this->belongsToMany(Permission::class)->where('slug', $permission)->exists();
        return $hasPermission;
    }
}
