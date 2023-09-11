<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\SharedControler;
use App\Controllers\AclContoller;
use App\Models\ClientsModel;
use App\Models\Guarantor;
use App\Models\MikopoModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;
use Predis\Command\Argument\Server\To;

class WakopajiController extends BaseController
{
    private $shared;
    private $currentUser;
    private $currentpage;
    private $currentMicrofinance;
    private $model;
    public function __construct()
    {
        $this->shared  = new SharedControler;
        $this->model = new ClientsModel();
        $this->currentpage = 'wakopaji/';
        $this->currentMicrofinance = $this->shared->get_user_microfinance();
        $this->currentUser = $this->shared->getCurrentUserInfo();
    }
    public function index()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('view');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'view')) {
            $this->model->orderBy('full_name', 'ASC');
            $wakopajiWote = $this->model->where('microfinace_id',$this->currentMicrofinance['id'])->findAll();
            $data['wakopaji']= $wakopajiWote;
            return view('app_head',$data) . view($this->currentpage . 'orodha') . view('app_footer');
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    public function fomuYakuongeza()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            return view('app_head') . view($this->currentpage . 'ongeza') . view('app_footer');
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    public function kusanyafomuYakuongeza()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $rule  = [
                'jina-lakwanza' => 'required|max_length[100]|min_length[3]',
                'jina-lakati' => 'required|max_length[100]|min_length[3]',
                'jinalamwisho' => 'required|max_length[100]|min_length[3]',
                'jinsia' => 'required|max_length[100]|min_length[5]',
                'email' => 'required|valid_email',
                'simu' => 'required|max_length[10]|min_length[10]',
                'utaifa' => 'required|max_length[100]',
                'mkoa' => 'required|max_length[100]',
                'wilaya' => 'required|max_length[100]',
                'kata' => 'required|max_length[100]',
                'kijiji' => 'required|max_length[100]',
                'mtaa' => 'required|max_length[100]',
                'kabila' => 'required|max_length[100]',
                'nambayumba' => 'required|max_length[100]',
                'ainayakazi' => 'required|max_length[100]',
                'kazi' => 'required|max_length[100]',
                'sehemukazi' => 'required|max_length[100]',
                'ainakitambulisho' => 'required|max_length[100]',
                'nambakitambulisho' => 'required|max_length[100]',
                'maelezo' => 'required|max_length[1024]',
                'pichakitambulisho' => [
                    'uploaded[pichakitambulisho]',
                    'max_size[pichakitambulisho,3072]',
                    'mime_in[pichakitambulisho,image/png,image/jpg,image/webp]',
                    'ext_in[pichakitambulisho,png,jpg]',
                    'max_dims[pichakitambulisho,1024,768]',
                ],
                'pichapasport' => [
                    'uploaded[pichapasport]',
                    'max_size[pichapasport,3072]',
                    'mime_in[pichapasport,image/png,image/jpg,image/webp]',
                    'ext_in[pichapasport,png,jpg]',
                    'max_dims[pichapasport,1024,768]',
                ],


            ];
            if ($this->validate($rule)) {
                $post = $this->request->getPost([
                    'jina-lakwanza',
                    'jina-lakati',
                    'jinalamwisho',
                    'jinsia',
                    'email',
                    'simu',
                    'utaifa',
                    'mkoa',
                    'wilaya',
                    'kata',
                    'kijiji',
                    'mtaa',
                    'kabila',
                    'nambayumba',
                    'ainayakazi',
                    'kazi',
                    'sehemukazi',
                    'ainakitambulisho',
                    'nambakitambulisho',
                    'maelezo',

                ]);
                $pasportsize = $this->request->getFile('pichapasport');
                $kitambulisho = $this->request->getFile('pichakitambulisho');
                if (!$pasportsize->hasMoved() && !$kitambulisho->hasMoved()) {
                    $pasport_path = WRITEPATH . 'uploads/' . $pasportsize->store();
                    $kitambulisho_path = WRITEPATH . 'uploads/' . $kitambulisho->store();
                    $destination = ROOTPATH . 'public/assets/uploads/';
                    $file = new File($pasport_path);
                    $pasport_url = base_url('assets/uploads/') . $file->getBasename();
                    $file->move($destination);
                    $file = new File($kitambulisho_path);
                    $kitambulisho_url = base_url('assets/uploads/') . $file->getBasename();
                    $file->move($destination);
                    $this->model->setAllowedFields([
                        'refercence_no','full_name','middle_name', 'last_name', 'gender', 'email', 'phone', 'tribe', 'nationality', 'region','district', 'street', 'ward', 'village', 'house_no', 'occupation','sehemu_yakazi','type_ofwork', 'idcard_type', 'id_no','maelezobinafsi', 'pasport', 'id_card', 'microfinace_id','created_by'
                    ]);
                    $datatoinsert = [
                        'refercence_no'=> "M/0".$this->currentMicrofinance['id']."/".date("Y")."0/", 
                        'full_name' => $post['jina-lakwanza'],
                        'middle_name' => $post['jina-lakati'],
                        'last_name' => $post['jinalamwisho'],
                        'gender' => $post['jinsia'],
                        'email' => $post['email'],
                        'phone' => $post['simu'],
                        'tribe' => $post['kabila'],
                        'nationality' => $post['utaifa'],
                        'region' => $post['mkoa'],
                        'district'=>$post['wilaya'],
                        'street' => $post['mtaa'],
                        'ward' => $post['kata'],
                        'village' => $post['kijiji'],
                        'house_no' => $post['nambayumba'],
                        'type_ofwork'=>$post['ainayakazi'],
                        'occupation' => $post['kazi'],
                        'sehemu_yakazi'=> $post['sehemukazi'],
                        'idcard_type' => $post['ainakitambulisho'],
                        'id_no' => $post['nambakitambulisho'],
                        'maelezobinafsi'=>$post['maelezo'],
                        'pasport' => $pasport_url,
                        'id_card' => $kitambulisho_url,
                        'microfinace_id' => $this->currentMicrofinance['id'],
                        'created_by'=>$this->shared->decrypt(base64_decode(session()->USER_ID))
                    ];
                    
                    if($this->model->save($datatoinsert)){
                        $mkid = $this->model->lastinsetreddata();
                        return redirect()->to('/tazamamkopaji'.'/'.base64_encode($this->shared->simpleEncrypt($mkid)));
                    }else{
                        var_dump($this->model->errors());
                    }
                }
            } else {
                return redirect()->back()->withInput();
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }

    public function fomuYakuhariri()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            return view('app_head') . view($this->currentpage . 'edit') . view('app_footer');
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    public function kusanyafomuYkuhariri()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            return view('app_head') . view($this->currentpage . 'ongeza') . view('app_footer');
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }

    public function tazama($id)
    {
        $id = $id;
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {

        $mokopajid =  $this->shared->simpleDecrypt(base64_decode($id));
        if(is_numeric($mokopajid)){
            $hisId = $this->shared->simpleDecrypt(base64_decode($id));
            $model = new Guarantor();
            $wadhamin = $model->getSponsersByUser($mokopajid,$this->currentMicrofinance['id']);
            $model = new MikopoModel();
            $mikopo_liyopitilzaMuda = $model->getOverDueLoansbyUser($mokopajid,$this->currentMicrofinance['id']);
            $mikopo_haijaLipwa_atakidogo = $model->getHajiaguswaLoansbyUser($mokopajid,$this->currentMicrofinance['id']);
            $madeniyote = $model->getAllLoansbyUser($mokopajid,$this->currentMicrofinance['id']);
            $hajamalizika = $model->getincompletengLoansbyUser($mokopajid,$this->currentMicrofinance['id']);
            $mokopajiInfo = $this->model->where('id',$mokopajid,true)->first();
            $data['mkopaji']=$mokopajiInfo;
            $data['wadhmaini']=$wadhamin;
            $data['mikopo_iliyopitilza']= $mikopo_liyopitilzaMuda;
            $data['iliyomalizika'] = $mikopo_haijaLipwa_atakidogo;
            $data['haijamalizka']=$hajamalizika;
            $data['madeniyote'] = $madeniyote;



            return  view('app_head',$data) . view($this->currentpage . 'tazama') . view('app_footer');
        }else{
            throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
        }
        
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
   
}
