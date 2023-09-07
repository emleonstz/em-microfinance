<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AclContoller extends BaseController
{
    private $roles = [];
    private $resources = [];
    private $permissions = [];

    public function __construct() {
        $this->roles = [
            'director',
            'collector',
            'loan_officer',
        ];
        $this->resources = [
            'collectors_dash',
            'loanofficer_dash',
            'director_dash',
        ];
        $this->permissions = [
            'view',
            'edit',
            'delete',
            'add',
        ];
    }

    public function addRole($role) {
        $this->roles[] = $role;
    }

    public function addResource($resource) {
        $this->resources[] = $resource;
    }

    public function addPermission($permission) {
        $this->permissions[] = $permission;
    }

    public function isAllowed($role, $resource, $permission) {
        return in_array($role, $this->roles) && in_array($resource, $this->resources) && in_array($permission, $this->permissions);
    }
}
