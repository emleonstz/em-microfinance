<?php

namespace App\Controllers;

use App\Controllers\SharedControler;
use App\Controllers\AclContoller;
use App\Models\ClientsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{
    private $shared;
    private $currentUser;
    private $currentMicrofinance;
    private $acl;
    public function __construct()
    {
        $this->shared  = new SharedControler;
        $this->currentUser = $this->shared->getCurrentUserInfo();
        $this->currentMicrofinance = $this->shared->get_user_microfinance();
        $this->acl = new AclContoller;
    }
    public function index()
    {
        
        $pages  = 'undifined';
        $data['wakopaji'] = null;
        if($this->currentUser['system_role']=="mkusanyaji" || $this->currentUser['system_role']=="mapokezi"){
            $model = new ClientsModel();
            $data['wakopaji']= $model->where('microfinace_id',$this->currentMicrofinance['id'])->orderBy('full_name','ASC')->findAll();
            $pages = 'collection_officer';
        }elseif($this->currentUser['system_role']=="mhasibu" || $this->currentUser['system_role']=="afisa_mkopo"){
            $pages = 'loan_officer';
        }elseif($this->currentUser['system_role']=="meneja" || $this->currentUser['system_role']=="mkurugenzi"){
            $pages = 'board_directors';
        }
        if (is_file(APPPATH."views/".$pages.".php")) {
            return view('app_head',$data) . view($pages) . view('app_footer');
        }else{
            throw new PageNotFoundException("Mtumiaji hatambuliki");
        }
    }
}
