<?php

namespace App\Domains\Auth\Services;

use App\Domains\Auth\Models\Permission;
use App\Services\BasicService;

/**
 * Class PermissionService.
 */
class PermissionService extends BasicService
{
    /**
     * PermissionService constructor.
     *
     * @param  Permission  $permission
     */
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    /**
     * @return mixed
     */
    public function getCategorizedPermissions()
    {
        return $this->model::isMaster()
            ->with('children')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getUncategorizedPermissions()
    {
        return $this->model::singular()
            ->orderBy('sort', 'asc')
            ->get();
    }
}
