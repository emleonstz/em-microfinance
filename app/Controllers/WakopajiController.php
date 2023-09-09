<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\SharedControler;
use App\Controllers\AclContoller;

class WakopajiController extends BaseController
{
    private $shared;
    private $currentUser;
    private $currentpage;
    public function __construct()
    {
        $this->shared  = new SharedControler;
        $this->currentpage = 'wakopaji/';
        $this->currentUser = $this->shared->getCurrentUserInfo();
        
    }
    public function index()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage.'orodha');
        $acl->addPerm('view');
        if($acl->amerusiwa($this->currentUser['system_role'],$this->currentpage.'orodha','view')){
            return view('app_head') . view($this->currentpage.'orodha') . view('app_footer');
        }else{
            return view('app_head') . view('notfound') . view('app_footer');
        }
        
    }
    public function fomuYakuongeza()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage.'orodha');
        $acl->addPerm('add');
        if($acl->amerusiwa($this->currentUser['system_role'],$this->currentpage.'orodha','add')){
            return view('app_head') . view($this->currentpage.'ongeza') . view('app_footer');
        }else{
            return view('app_head') . view('notfound') . view('app_footer');
        }
        
    }
    public function kusanyafomuYakuongeza()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage.'orodha');
        $acl->addPerm('add');
        if($acl->amerusiwa($this->currentUser['system_role'],$this->currentpage.'orodha','add')){
            $rule  = [
                'jina-lakwanza'=>'required|max_length[100]|min_length[3]',
                'jina-lakati'=>'required|max_length[100]|min_length[3]',
                'jinalamwisho'=>'required|max_length[100]|min_length[3]',
                'jinsia'=>'required|max_length[100]|min_length[5]',
                'email'=>'required|valid_email',
                'simu'=>'required|max_length[10]|min_length[10]',
                'utaifa'=>'required|max_length[100]',
                'mkoa'=>'required|max_length[100]',
                'wilaya'=>'required|max_length[100]',
                'kata'=>'required|max_length[100]',
                'kijiji'=>'required|max_length[100]',
                'mtaa'=>'required|max_length[100]',
                'kabila'=>'required|max_length[100]',
                'nambayumba'=>'required|max_length[100]',
                'ainayakazi'=>'required|max_length[100]',
                'kazi'=>'required|max_length[100]',
                'sehemukazi'=>'required|max_length[100]',
                'ainakitambulisho'=>'required|max_length[100]',
                'nambakitambulisho'=>'required|max_length[100]',
                'maelezo'=>'required|max_length[100]',
                'pichakitambulisho'=>[
                    'uploaded[pichakitambulisho]',
                    'max_size[pichakitambulisho,3072]',
                    'mime_in[pichakitambulisho,image/png,image/jpg,image/webp]',
                    'ext_in[pichakitambulisho,png,jpg]',
                    'max_dims[pichakitambulisho,1024,768]',
                ],
                'pichapasport'=>[
                    'uploaded[pichapasport]',
                    'max_size[pichapasport,3072]',
                    'mime_in[pichapasport,image/png,image/jpg,image/webp]',
                    'ext_in[pichapasport,png,jpg]',
                    'max_dims[pichapasport,1024,768]',
                ],


            ];
            if($this->validate($rule)){

            }else{
                return redirect()->back()->withInput();
            }
        }else{
            return view('app_head') . view('notfound') . view('app_footer');
        }
        
    }

    public function fomuYakuhariri()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage.'orodha');
        $acl->addPerm('add');
        if($acl->amerusiwa($this->currentUser['system_role'],$this->currentpage.'orodha','add')){
            return view('app_head') . view($this->currentpage.'edit') . view('app_footer');
        }else{
            return view('app_head') . view('notfound') . view('app_footer');
        }
        
    }
    public function kusanyafomuYkuhariri()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage.'orodha');
        $acl->addPerm('add');
        if($acl->amerusiwa($this->currentUser['system_role'],$this->currentpage.'orodha','add')){
            return view('app_head') . view($this->currentpage.'ongeza') . view('app_footer');
        }else{
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }

    public function tazama($di)
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage.'orodha');
        $acl->addPerm('add');
        if($acl->amerusiwa($this->currentUser['system_role'],$this->currentpage.'orodha','add')){
            return view('app_head') . view($this->currentpage.'ongeza') . view('app_footer');
        }else{
            return view('app_head') . view('notfound') . view('app_footer');
        }
        
    }
       

}
