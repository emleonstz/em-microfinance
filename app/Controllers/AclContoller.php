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
            
        ];
        $this->resources = [
            
        ];
        $this->permissions = [
            
        ];
    }

    public function ruhusu($role) {
        $this->roles[] = $role;
    }

    public function kwenyepage($resource) {
        $this->resources[] = $resource;
    }

    public function addPerm($permission) {
        $this->permissions[] = $permission;
    }

    public function amerusiwa($role, $resource, $permission) {
        return in_array($role, $this->roles) && in_array($resource, $this->resources) && in_array($permission, $this->permissions);
    }
    public function viewDashboard($userole){
        if($userole=="collector" || $userole=="teller"){
            $this->ruhusu('collector');
            $this->ruhusu('teller');
            $this->kwenyepage('collectors_dash');
            $this->addPerm('view');
            if($this->amerusiwa($userole,'collectors_dash','view')){
                return view('app_head') .view('collection_officer').view('app_footer');
            }else{
               die("hi");
            }
        }
    }
}
