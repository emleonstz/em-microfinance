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
            $wakopajiWote = $this->model->where('microfinace_id', $this->currentMicrofinance['id'])->findAll();
            $data['wakopaji'] = $wakopajiWote;
            return view('app_head', $data) . view($this->currentpage . 'orodha') . view('app_footer');
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
                        'refercence_no', 'full_name', 'middle_name', 'last_name', 'gender', 'email', 'phone', 'tribe', 'nationality', 'region', 'district', 'street', 'ward', 'village', 'house_no', 'occupation', 'sehemu_yakazi', 'type_ofwork', 'idcard_type', 'id_no', 'maelezobinafsi', 'pasport', 'id_card', 'microfinace_id', 'created_by'
                    ]);
                    $datatoinsert = [
                        'refercence_no' => "M/0" . $this->currentMicrofinance['id'] . "/" . date("Y") . "/0",
                        'full_name' => $post['jina-lakwanza'],
                        'middle_name' => $post['jina-lakati'],
                        'last_name' => $post['jinalamwisho'],
                        'gender' => $post['jinsia'],
                        'email' => $post['email'],
                        'phone' => $post['simu'],
                        'tribe' => $post['kabila'],
                        'nationality' => $post['utaifa'],
                        'region' => $post['mkoa'],
                        'district' => $post['wilaya'],
                        'street' => $post['mtaa'],
                        'ward' => $post['kata'],
                        'village' => $post['kijiji'],
                        'house_no' => $post['nambayumba'],
                        'type_ofwork' => $post['ainayakazi'],
                        'occupation' => $post['kazi'],
                        'sehemu_yakazi' => $post['sehemukazi'],
                        'idcard_type' => $post['ainakitambulisho'],
                        'id_no' => $post['nambakitambulisho'],
                        'maelezobinafsi' => $post['maelezo'],
                        'pasport' => $pasport_url,
                        'id_card' => $kitambulisho_url,
                        'microfinace_id' => $this->currentMicrofinance['id'],
                        'created_by' => $this->shared->decrypt(base64_decode(session()->USER_ID))
                    ];

                    if ($this->model->save($datatoinsert)) {
                        $mkid = $this->model->lastinsetreddata();
                        return redirect()->to('/tazamamkopaji' . '/' . base64_encode($this->shared->simpleEncrypt($mkid)));
                    } else {
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

    public function fomuYakuhariri($id)
    {
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mokopajid =  $this->shared->simpleDecrypt(base64_decode($id));
            if (is_numeric($mokopajid)) {
                $hisId = $this->shared->simpleDecrypt(base64_decode($id));
                $model = new Guarantor();
                $wadhamin = $model->getSponsersByUser($mokopajid, $this->currentMicrofinance['id']);
                $model = new MikopoModel();
                $mikopo_liyopitilzaMuda = $model->getOverDueLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $mikopo_haijaLipwa_atakidogo = $model->getHajiaguswaLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $madeniyote = $model->getAllLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $hajamalizika = $model->getincompletengLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $mokopajiInfo = $this->model->where('id', $mokopajid, true)->first();
                $data['mkopaji'] = $mokopajiInfo;
                if(! empty($madeniyote) && is_array($madeniyote)){
                    return redirect()->back()->with('error',"Huwezi kuhariri taarifa za mkopaji huyu kwasababu anamikopo ambayo haijalipwa tafadhali hakikisha mtumiaji amelipa mikopo yake kwanza");
                }else{
                    if($mokopajiInfo['account_status']=="Blocked"){
                        return redirect()->back()->with('error',"Mtumiaji amezuiliwa kutumia huduma zetu");
                    }else{
                        return view('app_head',$data) . view($this->currentpage . 'edit') . view('app_footer');
                    }
                }
                
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
            
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
                'mkopajiid'=>'required|min_length[5]',
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
                    'mkopajiid',
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
                        'refercence_no', 'full_name', 'middle_name', 'last_name', 'gender', 'email', 'phone', 'tribe', 'nationality', 'region', 'district', 'street', 'ward', 'village', 'house_no', 'occupation', 'sehemu_yakazi', 'type_ofwork', 'idcard_type', 'id_no', 'maelezobinafsi', 'pasport', 'id_card','account_status', 'microfinace_id', 'created_by'
                    ]);
                    $datatoinsert = [
                        'refercence_no' => "M/0" . $this->currentMicrofinance['id'] . "/" . date("Y") . "/0",
                        'full_name' => $post['jina-lakwanza'],
                        'middle_name' => $post['jina-lakati'],
                        'last_name' => $post['jinalamwisho'],
                        'gender' => $post['jinsia'],
                        'email' => $post['email'],
                        'phone' => $post['simu'],
                        'tribe' => $post['kabila'],
                        'nationality' => $post['utaifa'],
                        'region' => $post['mkoa'],
                        'district' => $post['wilaya'],
                        'street' => $post['mtaa'],
                        'ward' => $post['kata'],
                        'village' => $post['kijiji'],
                        'house_no' => $post['nambayumba'],
                        'type_ofwork' => $post['ainayakazi'],
                        'occupation' => $post['kazi'],
                        'sehemu_yakazi' => $post['sehemukazi'],
                        'idcard_type' => $post['ainakitambulisho'],
                        'id_no' => $post['nambakitambulisho'],
                        'maelezobinafsi' => $post['maelezo'],
                        'pasport' => $pasport_url,
                        'id_card' => $kitambulisho_url,
                        'account_status'=>"Pending",
                        'microfinace_id' => $this->currentMicrofinance['id'],
                        'created_by' => $this->shared->decrypt(base64_decode(session()->USER_ID))
                    ];

                    if ($this->model->update($this->shared->simpleDecrypt(base64_decode($post['mkopajiid'])),$datatoinsert)) {
                        return redirect()->to('/tazamamkopaji' . '/' . base64_encode($this->shared->simpleEncrypt($this->shared->simpleDecrypt(base64_decode($post['mkopajiid'])))));
                    } else {
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
            if (is_numeric($mokopajid)) {
                $hisId = $this->shared->simpleDecrypt(base64_decode($id));
                $model = new Guarantor();
                $wadhamin = $model->getSponsersByUser($mokopajid, $this->currentMicrofinance['id']);
                $model = new MikopoModel();
                $mikopo_liyopitilzaMuda = $model->getOverDueLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $mikopo_haijaLipwa_atakidogo = $model->getHajiaguswaLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $madeniyote = $model->getAllLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $hajamalizika = $model->getincompletengLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $mokopajiInfo = $this->model->where('id', $mokopajid, true)->first();
                $data['mkopaji'] = $mokopajiInfo;
                $data['wadhmaini'] = $wadhamin;
                $data['mikopo_iliyopitilza'] = $mikopo_liyopitilzaMuda;
                $data['iliyomalizika'] = $mikopo_haijaLipwa_atakidogo;
                $data['haijamalizka'] = $hajamalizika;
                $data['madeniyote'] = $madeniyote;



                return  view('app_head', $data) . view($this->currentpage . 'tazama') . view('app_footer');
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    public function pakuafomu($id)
    {
        $id = $id;
        $acl = new AclContoller;
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {

            $mokopajid =  $this->shared->simpleDecrypt(base64_decode($id));
            if (is_numeric($mokopajid)) {
                $hisId = $this->shared->simpleDecrypt(base64_decode($id));
                $model = new Guarantor();
                $wadhamin = $model->getSponsersByUser($mokopajid, $this->currentMicrofinance['id']);
                $model = new MikopoModel();
                $mikopo_liyopitilzaMuda = $model->getOverDueLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $mikopo_haijaLipwa_atakidogo = $model->getHajiaguswaLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $madeniyote = $model->getAllLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $hajamalizika = $model->getincompletengLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $mokopajiInfo = $this->model->where('id', $mokopajid, true)->first();
                $data['mkopaji'] = $mokopajiInfo;
                $data['wadhmaini'] = $wadhamin;
                $data['mikopo_iliyopitilza'] = $mikopo_liyopitilzaMuda;
                $data['iliyomalizika'] = $mikopo_haijaLipwa_atakidogo;
                $data['haijamalizka'] = $hajamalizika;
                $data['madeniyote'] = $madeniyote;


                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML('
            
                    <div style="text-align: left;">
                        <img src="' . ROOTPATH . 'public/assets/uploads/' . basename($mokopajiInfo['pasport']) . '" style="width:50px; object-fit:contain; height:50px; margin: 0 auto;" alt="paspoti">
                    </div>
                    <div style="text-align: center;">
                        <h3><u>' . strtoupper($this->currentMicrofinance['name']) . ' FOMU YA MAOMBI YA KUTAMBULIKA KAMA MKOPAJI HALALI</u></h3>
                    </div>
                    </div>
                ');


                $mpdf->WriteHTML('<p>Mkataba huu unaeleza masharti na kanuni ambazo mkopaji lazima afuate ili kua mkopaji halali wa ' . strtoupper($this->currentMicrofinance['name']) . '. Mkopaji lazima asajiliwe kakita mfumo wetu ilikupata fomu hii na kuambatanisha vitu vinavyohitajika.</p>');
                $mpdf->WriteHTML('<h3>1.MASHARTI YA KUTAMBULIKA KAMA MKOPAJI</h3>');
                $mpdf->WriteHTML('<p>Mimi, ' . strtoupper($mokopajiInfo['full_name'] . ' ' . $mokopajiInfo['middle_name'] . ' ' . $mokopajiInfo['last_name']) . ', kwa hiari yangu mwenyewe, ninakubali kuwa mkopaji halali katika ' . strtoupper($this->currentMicrofinance['name']) . '.</p>');
                $mpdf->WriteHTML('<p>Ninakubali kutii Sheria na Masharti yote ya ' . strtoupper($this->currentMicrofinance['name']) . ', ambayo ni pamoja na:</p>');
                $mpdf->WriteHTML('<p> i. Nitatoa taarifa sahihi na kamili kuhusu hali yangu ya kiuchumi kifedha na biashara.</p>');
                $mpdf->WriteHTML('<p> ii. Nitatoa dhamana ya kutosha kutekeleza majukumu yangu ya kifedha kwa ' . strtoupper($this->currentMicrofinance['name']) . ' pindi itakapo hitajika.</p>');
                $mpdf->WriteHTML('<p> iii. Nitatoa taarifa yoyote inayohitajika na ' . strtoupper($this->currentMicrofinance['name']) . ' kwa ajili ya ufuatiliaji wa mkopo wangu.</p>');
                $mpdf->WriteHTML('<p> iv. Nitalipa malipo ya mkopo wangu kwa wakati na kwa kiasi kamili.</p>');
                $mpdf->WriteHTML('<p> v. Nitatoa taarifa yoyote inayohitajika na ' . strtoupper($this->currentMicrofinance['name']) . ' kwa usahihi kwa ajili ya kuboresha huduma zake.</p>');
                $mpdf->WriteHTML('<p>Ninakubali kuwa ' . strtoupper($this->currentMicrofinance['name']) . ' inaweza kuchukua hatua za kisheria au za kimahakama dhidi yangu ikiwa sitatimiza majukumu yangu ya kifedha kwa ' . strtoupper($this->currentMicrofinance['name']) . '.</p>');
                $mpdf->WriteHTML('<h3>2.HUDUMA ZA ' . strtoupper($this->currentMicrofinance['name']) . '</h3>');
                $mpdf->WriteHTML('<p>' . strtoupper($this->currentMicrofinance['name']) . ' itatoa mikopo kwa wakopaji wake chini ya masharti na vigezo vilivyoanishwa.</p>');
                $mpdf->WriteHTML('<p>' . strtoupper($this->currentMicrofinance['name']) . ' itatoa mafunzo na ushauri wa kibiashara kwa wakopaji wake.</p>');
                $mpdf->WriteHTML('<h3>3.WAJIBU WA MKOPAJI</h3>');
                $mpdf->WriteHTML('<p> i. Kulipa marejesho ya mikopo kwa wakati.</p>');
                $mpdf->WriteHTML('<p> ii. Kufuata kanuni na taratibu zote za ' . strtoupper($this->currentMicrofinance['name']) . '.</p>');
                $mpdf->WriteHTML('<p> iii. Kutotoa taarifa zisizo sahihi wakati wa usaili.</p>');
                $mpdf->WriteHTML('<p>Mkataba huu uliandikwa tarehe ' . date("d/m/Y") . '.</p>');
                $mpdf->WriteHTML('<p>Sahihi ya Mkopaji:_______________________  Tarehe:______________________</p>');
                $mpdf->WriteHTML('<p>Afisa Mikopo:_______________________ Sahihi:______________________ Tarehe:______________________</p>');
                $mpdf->WriteHTML('<h3>4.TAARIFA BINAFSI ZA MKOPAJI</h3>');
                $mpdf->WriteHTML('<p>Jina Kamili: ' . strtoupper($mokopajiInfo['full_name'] . ' ' . $mokopajiInfo['middle_name'] . ' ' . $mokopajiInfo['last_name']) . '</p>');
                $mpdf->WriteHTML('<p>Jinsia :' . $mokopajiInfo['gender'] . ' </p>');
                $mpdf->WriteHTML('<p>Utaifa: ' . $mokopajiInfo['nationality'] . ' </p>');
                $mpdf->WriteHTML('<p>Mkoa: ' . $mokopajiInfo['region'] . ' </p>');
                $mpdf->WriteHTML('<p>Wilaya: ' . $mokopajiInfo['district'] . ' </p>');
                $mpdf->WriteHTML('<p>Kata: ' . $mokopajiInfo['ward'] . ' </p>');
                $mpdf->WriteHTML('<p>Kijiji: ' . $mokopajiInfo['village'] . ' </p>');
                $mpdf->WriteHTML('<p>Mtaa: ' . $mokopajiInfo['street'] . ' </p>');
                $mpdf->WriteHTML('<p>Kabila: ' . $mokopajiInfo['tribe'] . ' </p>');
                $tdata = '<table border="1" width="100%" cellspacing="0" cellpadding="5">
                <thead>
                  <tr>
                    <th>Kitambulisho </th>
                    <th>Namba</th>
                  </tr>
                </thead><tbody>';
                $mpdf->WriteHTML($tdata);
                $mpdf->WriteHTML('
            <tr>
            <td>' . $mokopajiInfo['idcard_type'] . '</td>
            <td>' . $mokopajiInfo['id_no'] . '</td>
            <tr>
            ');
                $mpdf->WriteHTML('</tbody></table>');
                $tdata = '<table border="1" width="100%" cellspacing="0" cellpadding="5">
                <thead>
                  <tr>
                    <th>Simu </th>
                    <th>Baruapepe</th>
                    <th>Namba ya nyumba</th>
                  </tr>
                </thead><tbody>';
                $mpdf->WriteHTML($tdata);
                $mpdf->WriteHTML('
            <tr>
            <td>' . $mokopajiInfo['phone'] . '</td>
            <td>' . $mokopajiInfo['email'] . '</td>
            <td>' . $mokopajiInfo['house_no'] . '</td>
            <tr>
            ');
                $mpdf->WriteHTML('</tbody></table>');
                $tdata = '<table border="1" width="100%" cellspacing="0" cellpadding="5">
                <thead>
                  <tr>
                    <th>Aina ya Kazi </th>
                    <th>Kazi</th>
                    <th>Sehemu ya kazi</th>
                  </tr>
                </thead><tbody>';
                $mpdf->WriteHTML($tdata);
                $mpdf->WriteHTML('
            <tr>
            <td>' . $mokopajiInfo['type_ofwork'] . '</td>
            <td>' . $mokopajiInfo['occupation'] . '</td>
            <td>' . $mokopajiInfo['sehemu_yakazi'] . '</td>
            <tr>
            ');
                $mpdf->WriteHTML('</tbody></table>');
                $mpdf->WriteHTML('<p>Mimi ______________________________ ninakiri kwamba malezeo yote niliyoyatoa hapo juu ni sahahi.</p>');
                $mpdf->WriteHTML('<p>Sahihi ya Mkopaji:____________________________</p>');
                $mpdf->WriteHTML('<h3>5.TAARIFA ZA MDHAMINI</h3>');
                //mdhamini
                $mpdf->WriteHTML('<p>Jina Kamili: ' . $wadhamin[0]['full_name'] . ' ' . $wadhamin[0]['full_name'] . '</p>');
                $mpdf->WriteHTML('<p>Jinsia :' . $wadhamin[0]['gender'] . ' </p>');
                $mpdf->WriteHTML('<p>Utaifa: ' . $wadhamin[0]['nationality'] . ' </p>');
                $mpdf->WriteHTML('<p>Mkoa: ' . $wadhamin[0]['region'] . ' </p>');
                $mpdf->WriteHTML('<p>Wilaya: ' . $wadhamin[0]['district'] . ' </p>');
                $mpdf->WriteHTML('<p>Kata: ' . $wadhamin[0]['ward'] . ' </p>');
                $mpdf->WriteHTML('<p>Kijiji: ' . $wadhamin[0]['village'] . ' </p>');
                $mpdf->WriteHTML('<p>Simu: ' . $wadhamin[0]['phone'] . ' </p>');

                $mpdf->WriteHTML('<p>Sahihi ya Mdhamini:____________________________</p>');
                //mdhamini ends
                $mpdf->WriteHTML('<span>Ofsi ya serikali za mtaa.</span>');
                $tdata = '<table border="1" width="100%" cellspacing="0" cellpadding="5">
                <thead>
                  <tr>
                    <th>Mwenyekiti wa kijiji </th>
                    <th>Balozi wa mtaa</th>
                  </tr>
                </thead><tbody>';
                $mpdf->WriteHTML($tdata);
                $mpdf->WriteHTML('
            <tr>
            <td>
            <p>Kijiji cha ' . $mokopajiInfo['village'] . '</p><br>
            <p>Jina:_________________________ </p><br>
            <p>Sahihi:________________________ </p><br>
            <p>Tarehe:________________________ </p><br>
            </td>
            <td>
            <p>Mtaa wa ' . $mokopajiInfo['street'] . '</p><br>
            <p>Jina:________________________ </p><br>
            <p>Sahihi:________________________ </p><br>
            <p>Tarehe:________________________ </p><br>
            </td>
            
            <tr>
            ');
                $mpdf->WriteHTML('</tbody></table>');
                //matumizi ya ofisi
                $mpdf->WriteHTML('<h3>6.Kwa matumizi ya ofisi</h3>');
                $tdata = '<table border="1" width="100%" cellspacing="0" cellpadding="5">
                <thead>
                  <tr>
                    <th>Afisa Mkikopo </th>
                    <th>muhuri wa ofisi</th>
                  </tr>
                </thead><tbody>';
                $mpdf->WriteHTML($tdata);
                $mpdf->WriteHTML('
            <tr>
            <td>
            <p>Afisa mikopo ' . $this->currentMicrofinance['name'] . '</p><br>
            <p>Jina:_________________________ </p><br>
            <p>Sahihi:________________________ </p><br>
            <p>Tarehe:________________________ </p><br>
            </td>
            <td>
            <br>
            <br>
            <br>
            <br>
            </td>
            
            <tr>
            ');
                $mpdf->WriteHTML('</tbody></table>');

                $mpdf->OutputHttpDownload('mkataba_wa_' . strtoupper($mokopajiInfo['full_name'] . '_' . $mokopajiInfo['middle_name'] . '_' . $mokopajiInfo['last_name']) . '.pdf');
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
}
