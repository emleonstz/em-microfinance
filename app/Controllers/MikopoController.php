<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MikopoModel;
use App\Controllers\SharedControler;
use App\Controllers\AclContoller;
use App\Models\ClientsModel;
use App\Models\Guarantor;
use App\Models\MalipoModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;
use DateTime;

class MikopoController extends BaseController
{
    private $shared;
    private $currentUser;
    private $currentpage;
    private $currentMicrofinance;
    private $model;
    public function __construct()
    {
        $this->shared  = new SharedControler;
        $this->model = new MikopoModel();
        $this->currentpage = 'mikopo/';
        $this->currentMicrofinance = $this->shared->get_user_microfinance();
        $this->currentUser = $this->shared->getCurrentUserInfo();
    }
    public function index($id)
    {
        $id = $id;
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
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
                $model = new ClientsModel();
                $mokopajiInfo = $model->where('id', $mokopajid, true)->first();
                $data['mkopaji'] = $mokopajiInfo;
                $data['wadhmaini'] = $wadhamin;
                $data['mikopo_iliyopitilza'] = $mikopo_liyopitilzaMuda;
                $data['iliyomalizika'] = $mikopo_haijaLipwa_atakidogo;
                $data['haijamalizka'] = $hajamalizika;
                $data['madeniyote'] = $madeniyote;
                if($mokopajiInfo['account_status'] == "Pending"){
                    return redirect()->back()->with('error',"Mkopaji hawezi kupewa mkopo kwasababu bado hajakamilisha usajili. Tafadhali wasilisha mkataba ulionasahihi zinazohitajika kwa afisa mikopo");
                }elseif($mokopajiInfo['account_status']=="Blocked"){
                    return redirect()->back()->with('error',"Mkopaji hawezi kupewa mkopo kwasababu amezuiliwa kutumia huduma zetu");
                }elseif($mokopajiInfo['account_status']=="Active"){
                    if(! count($madeniyote)<1){
                        return redirect()->back()->with('error',"Mkopaji hawezi kupewa mkopo mwingine kwa sababu hajamaliza malipo ya madeni ya zamani");
                    }else{
                        return  view('app_head', $data) . view($this->currentpage . 'omba') . view('app_footer');
                    }
                }


                
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    public function kototoa(){
        $rules = [
            'kiasi'=>'required|integer|max_length[9]|is_natural_no_zero|greater_than_equal_to[1000]',
            'ribaYaMwaka'=>'required|max_length[3]|is_natural_no_zero',
            'ainaYaMuda'=>'required',
            'muda'=>'required|integer|max_length[2]|is_natural_no_zero',
            'tareheYaKuanza'=>'required|valid_date'
        ];
        if($this->validate($rules)){
          $get = $this->request->getGet(['kiasi','ribaYaMwaka','muda','ainaYaMuda','tareheYaKuanza']); 
          $hesabu = $this->shared->kikokotooMkopo($get['kiasi'],$get['ribaYaMwaka'],$get['muda'],$get['ainaYaMuda'],$get['tareheYaKuanza']);
          return json_encode($hesabu);
        }else{
            return json_encode($this->validator->getErrors());
        }

    }

    public function processMkopo() {
        $rules = [
            'mkopajiid' => 'required|min_length[5]',
            'kiasi_chakukopa'=>'required|integer|max_length[9]|is_natural_no_zero|greater_than_equal_to[10000]',
            'ainaYaMuda'=>'required',
            'idadi_ya_muda'=>'required|integer|max_length[2]|is_natural_no_zero',
            'kiasi_kulipa_jumla'=>'required|integer|max_length[9]|is_natural_no_zero',
            'riba'=>'required|max_length[3]|is_natural_no_zero',
            'tareheYaKuanza'=>'required|valid_date',
            'tareheYaKuanzakulipa'=>'required|valid_date',
            'mali_yadhamna'=>'required|min_length[3]',
            'maelezo_ya_mali'=>'required',
            'picha_ya_mali' => [
                'uploaded[picha_ya_mali]',
                'max_size[picha_ya_mali,3072]',
                'mime_in[picha_ya_mali,image/png,image/jpg,image/webp]',
                'ext_in[picha_ya_mali,png,jpg]',
            ],
        ];
        if($this->validate($rules)){
        $post = $this->request->getPost(['mkopajiid','kiasi_chakukopa','ainaYaMuda','kiasi_kulipa_wiki', 'kiasi_kulipa_mwezi','idadi_ya_muda','kiasi_kulipa_jumla','riba','tareheYaKuanza','tareheYaKuanzakulipa','mali_yadhamna','maelezo_ya_mali']);
        $pichaYaMali = $this->request->getFile('picha_ya_mali');
        $destination = ROOTPATH . 'public/assets/uploads/';
        $pasport_path = WRITEPATH . 'uploads/' . $pichaYaMali->store();
        $file = new File($pasport_path);
        $pasport_url = base_url('assets/uploads/') . $file->getBasename();
        $file->move($destination);
        $id = $post['mkopajiid'];
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
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
                $model = new ClientsModel();
                $mokopajiInfo = $model->where('id', $mokopajid, true)->first();
                $data['mkopaji'] = $mokopajiInfo;
                $data['wadhmaini'] = $wadhamin;
                $data['mikopo_iliyopitilza'] = $mikopo_liyopitilzaMuda;
                $data['iliyomalizika'] = $mikopo_haijaLipwa_atakidogo;
                $data['haijamalizka'] = $hajamalizika;
                $data['madeniyote'] = $madeniyote;
                if($mokopajiInfo['account_status'] == "Pending"){
                    return redirect()->back()->with('error',"Mkopaji hawezi kupewa mkopo kwasababu bado hajakamilisha usajili. Tafadhali wasilisha mkataba ulionasahihi zinazohitajika kwa afisa mikopo");
                }elseif($mokopajiInfo['account_status']=="Blocked"){
                    return redirect()->back()->with('error',"Mkopaji hawezi kupewa mkopo kwasababu amezuiliwa kutumia huduma zetu");
                }elseif($mokopajiInfo['account_status']=="Active"){
                    if(! count($madeniyote)<1){
                        return redirect()->back()->with('error',"Mkopaji hawezi kupewa mkopo mwingine kwa sababu hajamaliza malipo ya madeni ya zamani");
                    }else{
                        $kwaawamu = 0;
                        $mara = 0;
                        if($post['ainaYaMuda']=="Wiki"){
                            if($post['kiasi_kulipa_wiki'] <1000){
                                return redirect()->back()->with('error',"Kiasi cha malipo ya kila wiki haiwezi kuwa chini ya 1000");  
                            }else{
                                $mara = $post['idadi_ya_muda'] * 4;
                                $kwaawamu = $post['kiasi_kulipa_wiki'] * $mara;
                            }
                        }elseif($post['ainaYaMuda']=="Mwezi"){
                            if($post['kiasi_kulipa_mwezi'] <1000){
                                return redirect()->back()->with('error',"Kiasi cha malipo ya kila mwezi haiwezi kuwa chini ya 1000");  
                            }else{
                                $mara= $post['idadi_ya_muda'];
                                $kwaawamu = $post['kiasi_kulipa_mwezi'];
                            }
                        }else{
                            return redirect()->back()->with('error',"chagua aina ya malipo");
                        }
                        $this->model->setAllowedFields(['client_id', 'principal_amount', 'duration', 'payment_amount', 'deadline_fee', 'borrowing_date', 'repayment_starts', 'unpaid_amount', 'assets_name','kiasi_kwa_awamu', 'asset_descriptions', 'asset_image', 'microfinance_id', 'loan_status', 'application_status', 'ndani_miezi', 'kulipa_kwa_kila', 'idadi_malipo','malipo_yanayofuata']);
                        $calculator = $this->shared->kikokotooMkopo($post['kiasi_chakukopa'],$post['riba'],$post['idadi_ya_muda'],strtolower($post['ainaYaMuda']),$post['tareheYaKuanza']);
                        $data = [
                            'client_id'=>$mokopajid, 
                            'principal_amount'=>$post['kiasi_chakukopa'], 
                            'duration'=>strtotime($calculator['tareheYaMwisho']), 
                            'payment_amount'=>$post['kiasi_kulipa_jumla'], 
                            'deadline_fee'=>'0', 
                            'borrowing_date'=>$post['tareheYaKuanza'], 
                            'repayment_starts'=>$post['tareheYaKuanzakulipa'], 
                            'unpaid_amount'=>$post['kiasi_kulipa_jumla'], 
                            'assets_name'=>$post['mali_yadhamna'], 
                            'asset_descriptions'=>$post['maelezo_ya_mali'], 
                            'asset_image'=>$pasport_url , 
                            'microfinance_id'=>$this->currentMicrofinance['id'], 
                            'loan_status'=>"Unpaid", 
                            'application_status'=>"Pending", 
                            'ndani_miezi'=>$post['idadi_ya_muda'], 
                            'kulipa_kwa_kila'=>$post['ainaYaMuda'], 
                            'kiasi_kwa_awamu'=>($post['ainaYaMuda']=="Wiki")?$post['kiasi_kulipa_wiki']:$post['kiasi_kulipa_mwezi'],
                            'idadi_malipo'=>$mara,
                            'malipo_yanayofuata'=>($post['ainaYaMuda']=="Mwezi")?$calculator['tareheKuanzaKulipamwezi']:$calculator['tareheKuanzaKulipaWiki']
                        ];
                        if($this->model->save($data)){
                            $mkopo = $this->model->getLastItemId();
                            $id = $mkopo['id'];
                            return redirect()->to('/tazamamkopo'.'/'.base64_encode($this->shared->simpleEncrypt($id)));
                        }else{
                            return redirect()->back()->with('error',"hitilafu ilitokea wakati wa mchakato wa kuhifadhi data kama tatizo litaendelea tafadhali wasiliana na msanidi programu");  
                        }
                    }
                }
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
        }else{
            return redirect()->back()->withInput();
        }

    }

    public function tazamaMkopo($id){
        $id = $id;
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mokoId =  $this->shared->simpleDecrypt(base64_decode($id));
            if (is_numeric($mokoId)) {
                $taarifaZamkopo = $this->model->where('id',$mokoId,true)->first();
                $mokopajid = $taarifaZamkopo['client_id'];
                //user data
                $model = new Guarantor();
                $wadhamin = $model->getSponsersByUser($mokopajid, $this->currentMicrofinance['id']);
                $model = new MikopoModel();
                $mikopo_liyopitilzaMuda = $model->getOverDueLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $mikopo_haijaLipwa_atakidogo = $model->getHajiaguswaLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $madeniyote = $model->getAllLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $hajamalizika = $model->getincompletengLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $model = new ClientsModel();
                $mokopajiInfo = $model->where('id', $mokopajid, true)->first();
                $model = new MalipoModel();
                $malipo =  $model->getMalipo($mokopajid,$mokoId,$this->currentMicrofinance['id']);
                $jumlailolipwa = $model->getTotalMalipo($mokopajid,$mokoId,$this->currentMicrofinance['id']);
                $data['mkopaji'] = $mokopajiInfo;
                $data['wadhmaini'] = $wadhamin;
                $data['taarifaZamkopo'] = $taarifaZamkopo;
                $data['malipo_ya_kopo'] = $malipo;
                $data['jumla_kalipa']=$jumlailolipwa;
                
                return  view('app_head', $data) . view($this->currentpage . 'tazama') . view('app_footer');
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        } 
    }

    public function ratibaYaMalipo($id){
        $id = $id;
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mokoId =  $this->shared->simpleDecrypt(base64_decode($id));
            if (is_numeric($mokoId)) {
                $taarifaZamkopo = $this->model->where('id',$mokoId,true)->first();
                $mokopajid = $taarifaZamkopo['client_id'];
                //user data
                $model = new Guarantor();
                $wadhamin = $model->getSponsersByUser($mokopajid, $this->currentMicrofinance['id']);
                $model = new MikopoModel();
                $mikopo_liyopitilzaMuda = $model->getOverDueLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $mikopo_haijaLipwa_atakidogo = $model->getHajiaguswaLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $madeniyote = $model->getAllLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $hajamalizika = $model->getincompletengLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $model = new ClientsModel();
                $mokopajiInfo = $model->where('id', $mokopajid, true)->first();
                $model = new MalipoModel();
                $malipo =  $model->getMalipo($mokopajid,$mokoId,$this->currentMicrofinance['id']);
                $jumlailolipwa = $model->getTotalMalipo($mokopajid,$mokoId,$this->currentMicrofinance['id']);
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML('
                    <div style="text-align: center;">
                        <h3><u>RATIBA YA MALIPO YA MKOPO</u></h3>
                    </div>
                    </div>');
                    $mpdf->WriteHTML('<p>Mkataba huu unaeleza masharti na kanuni ambazo mkopaji lazima afuate ili kua mkopaji halali wa ' . strtoupper($this->currentMicrofinance['name']) . '. Mkopaji lazima asajiliwe kakita mfumo wetu ilikupata fomu hii na kuambatanisha vitu vinavyohitajika.</p>');
                    $tdata = '<table border="1" width="100%" cellspacing="0" cellpadding="5">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Tarehe ya malopo </th>
                    <th>Kiasi cha kulipwa</th>
                    <th>Kiasi kitakacho salia (baada ya kulipa)</th>
                    <th>Amelipa (weka tiki)</th>
                    <th>Sahihi ya karani/mhasibu/Afisa Mikopo (aliyepokea fedha za malipo)  </th>
                  </tr>
                </thead><tbody>';
                $mpdf->WriteHTML($tdata);
                $datewiki = new DateTime($taarifaZamkopo['borrowing_date']);
                $num = $taarifaZamkopo['idadi_malipo'];
                $index = 1;
                $sum =  0;
                $deni = $taarifaZamkopo['payment_amount'];
                for ($i=0; $i < $num; $i++) { 
                    if($taarifaZamkopo['kulipa_kwa_kila'] == "Wiki"){
                        $date = $datewiki->modify("+7 days");
                        $sum =  $sum + $taarifaZamkopo['kiasi_kwa_awamu'];
                        $deni -= $taarifaZamkopo['kiasi_kwa_awamu'];
                        $mpdf->WriteHTML('
                        <tr>
                        <td>'.$index++.'</td>
                        <td>' . $date->format('F, d Y'). '</td>
                        <td>' . $this->shared->to_currency($taarifaZamkopo['kiasi_kwa_awamu'],'sw-Tz') . '</td>
                        <td>'.$this->shared->to_currency($deni,'sw-Tz').'</td>
                        <td><br></td>
                        <td><br></td>
                        <tr>
                        ');
                    }else{
                        $date = $datewiki->modify("+1 months");
                        $sum =  $sum + $taarifaZamkopo['kiasi_kwa_awamu'];
                        $deni -= $taarifaZamkopo['kiasi_kwa_awamu'];
                        $mpdf->WriteHTML('
                        <tr>
                        <td>'.$index++.'</td>
                        <td>' . $date->format('F, d Y'). '</td>
                        <td>' . $this->shared->to_currency($taarifaZamkopo['kiasi_kwa_awamu'],'sw-Tz') . '</td>
                        <td>'.$this->shared->to_currency($deni,'sw-Tz').'</td>
                        <td><br></td>
                        <td><br></td>
                        <tr>
                        ');
                    }
                }
                $mpdf->WriteHTML('<tr>
                <td colspan="2">****Mwisho****</td>
                <td>' . $this->shared->to_currency($sum,'sw-Tz'). '</td>
                <td>'.$this->shared->to_currency($deni,'sw-Tz').'</td>
                <td colspan="2">****Mwisho wa kulipa****</td>
                <tr>');
                
                $mpdf->WriteHTML('</tbody></table>');
                $mpdf->OutputHttpDownload('Ratiba_ya_' . strtoupper($mokopajiInfo['full_name'] . '_' . $mokopajiInfo['middle_name'] . '_' . $mokopajiInfo['last_name']) . '.pdf');
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }    
    }

    public function baruaYakuombaMkopo($id){
        $id = $id;
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mokoId =  $this->shared->simpleDecrypt(base64_decode($id));
            if (is_numeric($mokoId)) {
                $taarifaZamkopo = $this->model->where('id',$mokoId,true)->first();
                $mokopajid = $taarifaZamkopo['client_id'];
                //user data
                $model = new Guarantor();
                $wadhamin = $model->getSponsersByUser($mokopajid, $this->currentMicrofinance['id']);
                $model = new MikopoModel();
                $mikopo_liyopitilzaMuda = $model->getOverDueLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $mikopo_haijaLipwa_atakidogo = $model->getHajiaguswaLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $madeniyote = $model->getAllLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $hajamalizika = $model->getincompletengLoansbyUser($mokopajid, $this->currentMicrofinance['id']);
                $model = new ClientsModel();
                $mokopajiInfo = $model->where('id', $mokopajid, true)->first();
                $model = new MalipoModel();
                $malipo =  $model->getMalipo($mokopajid,$mokoId,$this->currentMicrofinance['id']);
                $jumlailolipwa = $model->getTotalMalipo($mokopajid,$mokoId,$this->currentMicrofinance['id']);
                
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        } 
    }
}
