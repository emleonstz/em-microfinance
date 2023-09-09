<?php

namespace App\Controllers;

use App\Controllers\SharedControler;
use App\Controllers\AclContoller;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    private $shared;
    private $currentUser;
    private $acl;
    public function __construct()
    {
        $this->shared  = new SharedControler;
        $this->currentUser = $this->shared->getCurrentUserInfo();
        $this->acl = new AclContoller;
    }
    public function index()
    {
        
        $pages  = 'undifined';
        if($this->currentUser['system_role']=="mkusanyaji" || $this->currentUser['system_role']=="mapokezi"){
            $pages = 'collection_officer';
        }elseif($this->currentUser['system_role']=="mhasibu" || $this->currentUser['system_role']=="afisa_mkopo"){
            $pages = 'loan_officer';
        }elseif($this->currentUser['system_role']=="meneja" || $this->currentUser['system_role']=="mkurugenzi"){
            $pages = 'board_directors';
        }
        if (is_file(APPPATH."views/".$pages.".php")) {
            return view('app_head') . view($pages) . view('app_footer');
        }else{
            throw new PageNotFoundException("Mtumiaji hatambuliki");
        }
    }
}
