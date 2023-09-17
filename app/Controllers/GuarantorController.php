<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\SharedControler;
use App\Controllers\AclContoller;
use App\Models\ClientsModel;
use App\Models\Guarantor;

class GuarantorController extends BaseController
{
    private $shared;
    private $currentUser;
    private $currentpage;
    private $currentMicrofinance;
    private $model;
    public function __construct()
    {
        $this->shared  = new SharedControler;
        $this->model = new Guarantor();
        $this->currentpage = 'wakopaji/';
        $this->currentMicrofinance = $this->shared->get_user_microfinance();
        $this->currentUser = $this->shared->getCurrentUserInfo();
    }
    public function index()
    {
        //
    }
    public function ongezaMdahamin()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {

            $rules = [
                'jina_lakwanza' => 'required|max_length[100]|min_length[3]',
                'jina_kati_miwsha' => 'required|max_length[100]|min_length[3]',
                'jinsia' => 'required|max_length[100]|min_length[5]',
                'utaifa' => 'required|max_length[100]|min_length[5]',
                'mkoa' => 'required|max_length[100]|min_length[4]',
                'wilaya' => 'required|max_length[100]|min_length[4]',
                'kata' => 'required|max_length[100]|min_length[4]',
                'kijiji' => 'required|max_length[100]|min_length[4]',
                'simu' => 'required|max_length[10]|min_length[10]',
                'mkopajiid' => 'required|min_length[8]',
                'email' => 'required|valid_email',
            ];
            if ($this->validate($rules)) {
                $this->model->setAllowedFields(['full_name', 'last_name', 'gender', 'nationality', 'region', 'district', 'ward', 'village', 'phone', 'email', 'client_id', 'microfinace_id']);
                $post = $this->request->getPost([
                    'jina_lakwanza',
                    'jina_kati_miwsha',
                    'jinsia',
                    'utaifa',
                    'mkoa',
                    'wilaya',
                    'kata',
                    'kijiji',
                    'simu',
                    'mkopajiid',
                    'email',
                ]);
                $data = [
                    'full_name' => $post['jina_lakwanza'],
                    'last_name' => $post['jina_kati_miwsha'],
                    'gender' => $post['jinsia'],
                    'nationality' => $post['utaifa'],
                    'region' => $post['mkoa'],
                    'district' => $post['wilaya'],
                    'ward' => $post['kata'],
                    'village' => $post['kijiji'],
                    'phone' => $post['simu'],
                    'email' => $post['email'],
                    'client_id' => $this->shared->simpleDecrypt(base64_decode($post['mkopajiid'])),
                    'microfinace_id' => $this->currentMicrofinance['id']
                ];
                if ($this->model->save($data)) {
                    return redirect()->back()->with('ujumbe', "imehifadhiwa kikamilifu");
                } else {
                    return redirect()->back()->withInput();
                }
            } else {
                return redirect()->back()->withInput();
            }
        }
    }
    public function haririMdahamin()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {

            $rules = [
                'jina_lakwanza' => 'required|max_length[100]|min_length[3]',
                'jina_kati_miwsha' => 'required|max_length[100]|min_length[3]',
                'jinsia' => 'required|max_length[100]|min_length[5]',
                'utaifa' => 'required|max_length[100]|min_length[5]',
                'mkoa' => 'required|max_length[100]|min_length[4]',
                'wilaya' => 'required|max_length[100]|min_length[4]',
                'kata' => 'required|max_length[100]|min_length[4]',
                'kijiji' => 'required|max_length[100]|min_length[4]',
                'simu' => 'required|max_length[10]|min_length[10]',
                'mkopajiid' => 'required|min_length[8]',
                'mdhaminiid'=>'required|min_length[8]',
                'email' => 'required|valid_email',
            ];
            if ($this->validate($rules)) {
                $this->model->setAllowedFields(['full_name', 'last_name', 'gender', 'nationality', 'region', 'district', 'ward', 'village', 'phone', 'email', 'client_id', 'microfinace_id']);
                $post = $this->request->getPost([
                    'jina_lakwanza',
                    'jina_kati_miwsha',
                    'jinsia',
                    'utaifa',
                    'mkoa',
                    'wilaya',
                    'kata',
                    'kijiji',
                    'simu',
                    'mkopajiid',
                    'mdhaminiid',
                    'email',
                ]);
                $data = [
                    'full_name' => $post['jina_lakwanza'],
                    'last_name' => $post['jina_kati_miwsha'],
                    'gender' => $post['jinsia'],
                    'nationality' => $post['utaifa'],
                    'region' => $post['mkoa'],
                    'district' => $post['wilaya'],
                    'ward' => $post['kata'],
                    'village' => $post['kijiji'],
                    'phone' => $post['simu'],
                    'email' => $post['email'],
                    'client_id' => $this->shared->simpleDecrypt(base64_decode($post['mkopajiid'])),
                    'microfinace_id' => $this->currentMicrofinance['id']
                ];
                if ($this->model->update($this->shared->simpleDecrypt(base64_decode($post['mdhaminiid'])),$data)) {
                    return redirect()->back()->with('ujumbe', "Mdhamini amehaririwa kikamilifu");
                } else {
                    return redirect()->back()->withInput();
                }
            } else {
                return redirect()->back()->withInput();
            }
        }
    }
}
