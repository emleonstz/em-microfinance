<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MikopoModel;
use App\Controllers\SharedControler;
use App\Controllers\AclContoller;
use App\Models\ClientsModel;
use App\Models\FailedLogins;
use App\Models\Guarantor;
use App\Models\MalipoModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\File;
use DateTime;
use Mpdf\Mpdf;

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
                if ($mokopajiInfo['account_status'] == "Pending") {
                    return redirect()->back()->with('error', "Mkopaji hawezi kupewa mkopo kwasababu bado hajakamilisha usajili. Tafadhali wasilisha mkataba ulionasahihi zinazohitajika kwa afisa mikopo");
                } elseif ($mokopajiInfo['account_status'] == "Blocked") {
                    return redirect()->back()->with('error', "Mkopaji hawezi kupewa mkopo kwasababu amezuiliwa kutumia huduma zetu");
                } elseif ($mokopajiInfo['account_status'] == "Active") {
                    if (!count($madeniyote) < 1) {
                        return redirect()->back()->with('error', "Mkopaji hawezi kupewa mkopo mwingine kwa sababu hajamaliza malipo ya madeni ya zamani");
                    } else {
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
    public function kototoa()
    {
        $rules = [
            'kiasi' => 'required|integer|max_length[9]|is_natural_no_zero|greater_than_equal_to[1000]',
            'ribaYaMwaka' => 'required|max_length[3]|is_natural_no_zero',
            'ainaYaMuda' => 'required',
            'muda' => 'required|integer|max_length[2]|is_natural_no_zero',
            'tareheYaKuanza' => 'required|valid_date'
        ];
        if ($this->validate($rules)) {
            $get = $this->request->getGet(['kiasi', 'ribaYaMwaka', 'muda', 'ainaYaMuda', 'tareheYaKuanza']);
            $hesabu = $this->shared->kikokotooMkopo($get['kiasi'], $get['ribaYaMwaka'], $get['muda'], $get['ainaYaMuda'], $get['tareheYaKuanza']);
            return json_encode($hesabu);
        } else {
            return json_encode($this->validator->getErrors());
        }
    }

    public function processMkopo()
    {
        $rules = [
            'mkopajiid' => 'required|min_length[5]',
            'kiasi_chakukopa' => 'required|integer|max_length[9]|is_natural_no_zero|greater_than_equal_to[10000]',
            'ainaYaMuda' => 'required',
            'idadi_ya_muda' => 'required|integer|max_length[2]|is_natural_no_zero',
            'kiasi_kulipa_jumla' => 'required|integer|max_length[9]|is_natural_no_zero',
            'riba' => 'required|max_length[3]|is_natural_no_zero',
            'tareheYaKuanza' => 'required|valid_date',
            'tareheYaKuanzakulipa' => 'required|valid_date',
            'mali_yadhamna' => 'required|min_length[3]',
            'maelezo_ya_mali' => 'required',
            'picha_ya_mali' => [
                'uploaded[picha_ya_mali]',
                'max_size[picha_ya_mali,3072]',
                'mime_in[picha_ya_mali,image/png,image/jpg,image/webp]',
                'ext_in[picha_ya_mali,png,jpg]',
            ],
        ];
        if ($this->validate($rules)) {
            $post = $this->request->getPost(['mkopajiid', 'kiasi_chakukopa', 'ainaYaMuda', 'kiasi_kulipa_wiki', 'kiasi_kulipa_mwezi', 'idadi_ya_muda', 'kiasi_kulipa_jumla', 'riba', 'tareheYaKuanza', 'tareheYaKuanzakulipa', 'mali_yadhamna', 'maelezo_ya_mali']);
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
                    if ($mokopajiInfo['account_status'] == "Pending") {
                        return redirect()->back()->with('error', "Mkopaji hawezi kupewa mkopo kwasababu bado hajakamilisha usajili. Tafadhali wasilisha mkataba ulionasahihi zinazohitajika kwa afisa mikopo");
                    } elseif ($mokopajiInfo['account_status'] == "Blocked") {
                        return redirect()->back()->with('error', "Mkopaji hawezi kupewa mkopo kwasababu amezuiliwa kutumia huduma zetu");
                    } elseif ($mokopajiInfo['account_status'] == "Active") {
                        if (!count($madeniyote) < 1) {
                            return redirect()->back()->with('error', "Mkopaji hawezi kupewa mkopo mwingine kwa sababu hajamaliza malipo ya madeni ya zamani");
                        } else {
                            $kwaawamu = 0;
                            $mara = 0;
                            if ($post['ainaYaMuda'] == "Wiki") {
                                if ($post['kiasi_kulipa_wiki'] < 1000) {
                                    return redirect()->back()->with('error', "Kiasi cha malipo ya kila wiki haiwezi kuwa chini ya 1000");
                                } else {
                                    $mara = $post['idadi_ya_muda'] * 4;
                                    $kwaawamu = $post['kiasi_kulipa_wiki'] * $mara;
                                }
                            } elseif ($post['ainaYaMuda'] == "Mwezi") {
                                if ($post['kiasi_kulipa_mwezi'] < 1000) {
                                    return redirect()->back()->with('error', "Kiasi cha malipo ya kila mwezi haiwezi kuwa chini ya 1000");
                                } else {
                                    $mara = $post['idadi_ya_muda'];
                                    $kwaawamu = $post['kiasi_kulipa_mwezi'];
                                }
                            } else {
                                return redirect()->back()->with('error', "chagua aina ya malipo");
                            }
                            $this->model->setAllowedFields(['client_id', 'principal_amount', 'duration', 'payment_amount', 'deadline_fee', 'borrowing_date', 'repayment_starts', 'unpaid_amount', 'assets_name', 'kiasi_kwa_awamu', 'asset_descriptions', 'asset_image', 'microfinance_id', 'loan_status', 'application_status', 'ndani_miezi', 'kulipa_kwa_kila', 'idadi_malipo', 'malipo_yanayofuata']);
                            $calculator = $this->shared->kikokotooMkopo($post['kiasi_chakukopa'], $post['riba'], $post['idadi_ya_muda'], strtolower($post['ainaYaMuda']), $post['tareheYaKuanza']);
                            $data = [
                                'client_id' => $mokopajid,
                                'principal_amount' => $post['kiasi_chakukopa'],
                                'duration' => strtotime($calculator['tareheYaMwisho']),
                                'payment_amount' => $post['kiasi_kulipa_jumla'],
                                'deadline_fee' => '0',
                                'borrowing_date' => $post['tareheYaKuanza'],
                                'repayment_starts' => $post['tareheYaKuanzakulipa'],
                                'unpaid_amount' => $post['kiasi_kulipa_jumla'],
                                'assets_name' => $post['mali_yadhamna'],
                                'asset_descriptions' => $post['maelezo_ya_mali'],
                                'asset_image' => $pasport_url,
                                'microfinance_id' => $this->currentMicrofinance['id'],
                                'loan_status' => "Unpaid",
                                'application_status' => "Pending",
                                'ndani_miezi' => $post['idadi_ya_muda'],
                                'kulipa_kwa_kila' => $post['ainaYaMuda'],
                                'kiasi_kwa_awamu' => ($post['ainaYaMuda'] == "Wiki") ? $post['kiasi_kulipa_wiki'] : $post['kiasi_kulipa_mwezi'],
                                'idadi_malipo' => $mara,
                                'malipo_yanayofuata' => ($post['ainaYaMuda'] == "Mwezi") ? $calculator['tareheKuanzaKulipamwezi'] : $calculator['tareheKuanzaKulipaWiki']
                            ];
                            if ($this->model->save($data)) {
                                $mkopo = $this->model->getLastItemId();
                                $id = $mkopo['id'];
                                return redirect()->to('/tazamamkopo' . '/' . base64_encode($this->shared->simpleEncrypt($id)));
                            } else {
                                return redirect()->back()->with('error', "hitilafu ilitokea wakati wa mchakato wa kuhifadhi data kama tatizo litaendelea tafadhali wasiliana na msanidi programu");
                            }
                        }
                    }
                } else {
                    throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
                }
            } else {
                return view('app_head') . view('notfound') . view('app_footer');
            }
        } else {
            return redirect()->back()->withInput();
        }
    }

    public function tazamaMkopo($id)
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
            $mokoId =  $this->shared->simpleDecrypt(base64_decode($id));
                $mokoId = $this->shared->cleanVar($mokoId);
            if (is_numeric($mokoId)) {
                $taarifaZamkopo = $this->model->where('id', $mokoId, true)->first();
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
                $malipo =  $model->getMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                $jumlailolipwa = $model->getTotalMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                $data['mkopaji'] = $mokopajiInfo;
                $data['wadhmaini'] = $wadhamin;
                $data['taarifaZamkopo'] = $taarifaZamkopo;
                $data['malipo_ya_kopo'] = $malipo;
                $data['jumla_kalipa'] = $jumlailolipwa;

                return  view('app_head', $data) . view($this->currentpage . 'tazama') . view('app_footer');
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }

    public function ratibaYaMalipo($id)
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
            $mokoId =  $this->shared->simpleDecrypt(base64_decode($id));
                $mokoId = $this->shared->cleanVar($mokoId);
            if (is_numeric($mokoId)) {
                $taarifaZamkopo = $this->model->where('id', $mokoId, true)->first();
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
                $malipo =  $model->getMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                $jumlailolipwa = $model->getTotalMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
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
                for ($i = 0; $i < $num; $i++) {
                    if ($taarifaZamkopo['kulipa_kwa_kila'] == "Wiki") {
                        $date = $datewiki->modify("+7 days");
                        $sum =  $sum + $taarifaZamkopo['kiasi_kwa_awamu'];
                        $deni -= $taarifaZamkopo['kiasi_kwa_awamu'];
                        $mpdf->WriteHTML('
                        <tr>
                        <td>' . $index++ . '</td>
                        <td>' . $date->format('F, d Y') . '</td>
                        <td>' . $this->shared->to_currency($taarifaZamkopo['kiasi_kwa_awamu'], 'sw-Tz') . '</td>
                        <td>' . $this->shared->to_currency($deni, 'sw-Tz') . '</td>
                        <td><br></td>
                        <td><br></td>
                        <tr>
                        ');
                    } else {
                        $date = $datewiki->modify("+1 months");
                        $sum =  $sum + $taarifaZamkopo['kiasi_kwa_awamu'];
                        $deni -= $taarifaZamkopo['kiasi_kwa_awamu'];
                        $mpdf->WriteHTML('
                        <tr>
                        <td>' . $index++ . '</td>
                        <td>' . $date->format('F, d Y') . '</td>
                        <td>' . $this->shared->to_currency($taarifaZamkopo['kiasi_kwa_awamu'], 'sw-Tz') . '</td>
                        <td>' . $this->shared->to_currency($deni, 'sw-Tz') . '</td>
                        <td><br></td>
                        <td><br></td>
                        <tr>
                        ');
                    }
                }
                $mpdf->WriteHTML('<tr>
                <td colspan="2">****Mwisho****</td>
                <td>' . $this->shared->to_currency($sum, 'sw-Tz') . '</td>
                <td>' . $this->shared->to_currency($deni, 'sw-Tz') . '</td>
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

    public function baruaYakuombaMkopo($id)
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
            $mokoId =  $this->shared->simpleDecrypt(base64_decode($id));
                $mokoId = $this->shared->cleanVar($mokoId);
            if (is_numeric($mokoId)) {
                $taarifaZamkopo = $this->model->where('id', $mokoId, true)->first();
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
                $malipo =  $model->getMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                $kiunganishi = ($taarifaZamkopo['kulipa_kwa_kila'] == "Mwezi") ? "wa" : "ya";
                $jumlailolipwa = $model->getTotalMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                $office = (isset($this->currentMicrofinance['postal_box'])) ? $this->currentMicrofinance['postal_box'] : $this->currentMicrofinance['office_no'];
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML('
                    <div style="text-align: center;">
                        <h3><u>' . strtoupper($this->currentMicrofinance['name']) . " " . strtoupper($office) . " " . strtoupper($this->currentMicrofinance['region']) . ' MKATABA WA KUOMBA MKOPO</u></h3>
                    </div>
                    </div>');
                $mpdf->WriteHTML('<p>Mkataba huu unamhusisha ndungu <strong>' . $mokopajiInfo['full_name'] . " " . $mokopajiInfo['middle_name'] . " " . $mokopajiInfo['last_name'] . '</strong> ambaye atatambulika kama <strong>Mkopaji</strong> na <strong>' . $this->currentMicrofinance['name'] . '</strong> ambayo itatambulika kama <strong>Mkopeshaji</strong> </p>');
                $mpdf->writeHTML('<p>Mkopaji anakubaliana kupokea kutoka kwa Mkopeshaji kiasi cha mkopo wa ' . $this->shared->to_currency($taarifaZamkopo['principal_amount'], 'sw-Tz') . ' kiasi kwa maneno:____________________________ siku ya leo tarehe __________________________ na atarejesha kiasi cha ' . $this->shared->to_currency($taarifaZamkopo['payment_amount'], 'sw-Tz') . ' kiasi kwa maneno_______________________________________ kwa utaratibu  ulioainishwa hapa chini.</p>');
                $mpdf->WriteHTML('<h3>1. Makubaliano ya Malipo</h3>');
                $mpdf->WriteHTML('<p>Mkopaji atalipa mkopo huu katika viwango vya kila ' . $taarifaZamkopo['kulipa_kwa_kila'] . ' kiasi cha  ' . $this->shared->to_currency($taarifaZamkopo['kiasi_kwa_awamu'], 'sw-Tz') . ' kuanzia ' . $taarifaZamkopo['kulipa_kwa_kila'] . ' ' . $kiunganishi . ' kwanza baada ya kupokea mkopo huu ambapo ya malipo ya kwanza ya taanza kupokelewa tarehe ' . date("d/F/Y", strtotime($taarifaZamkopo['repayment_starts'])) . ' mkopo huu utahesabika kama mkopo uliopitiliza muda wa malipo ikiwa malipo ya kulipa kwa awamu hayatakamilisha malipo ya deni zima ifikapo tahera ' . date("d/F/Y", $taarifaZamkopo['duration']) . '.</p>');
                $mpdf->WriteHTML('<h3>2. Muda wa mkopo</h3>');
                $mpdf->WriteHTML('<p>Mkopo huu utalipwa ndani ya muda wa miezi ' . $taarifaZamkopo['ndani_miezi'] . ' kutoka tarehe ya kusainiwa kwa mkataba huu.</p>');
                $mpdf->WriteHTML('<h3>4. Malipo ya Mapema</h3>');
                $mpdf->WriteHTML('<p>Mkopaji anaweza kulipia mkopo huu kabla ya muda wa mwisho wa mkataba kwa riba inayostahili malipo ya awali.</p>');
                $mpdf->WriteHTML('<h3>3. Dhamana ya mkopo</h3>');
                $mpdf->WriteHTML('<p>Mkopaji ametoa dhamana kwa mujibu wa sera za ' . $this->currentMicrofinance['name'] . '.</p>');
                //futa ka vp
                $tdata = '<table border="1" width="100%" cellspacing="0" cellpadding="5">
                <thead>
                  <tr>
                    <th>Mali ya dahama </th>
                    <th>Maelezo ya mali</th>
                  </tr>
                </thead><tbody>';
                $mpdf->WriteHTML($tdata);
                $mpdf->WriteHTML('
            <tr>
            <td>
            <p>' . $taarifaZamkopo['assets_name'] . '</p><br>
            </td>
            <td>
            <p>' . $taarifaZamkopo['asset_descriptions'] . '</p><br>
            </td>
            
            <tr>
            ');
                $mpdf->WriteHTML('</tbody></table>');
                //mwisho wa dhamna
                $mpdf->WriteHTML('<p>Mkopaji anakubaliana kuwa ukiukaji wa mkataba huu utasababisha hatua za kisheria kwa mujibu wa sheria na sera za ' . $this->currentMicrofinance['name'] . '</p>');
                $mpdf->WriteHTML('<p>Mimi ' . $mokopajiInfo['full_name'] . " " . $mokopajiInfo['middle_name'] . " " . $mokopajiInfo['last_name'] . '</strong> ambaye natambulika kama <strong>Mkopaji</strong> wa ' . $this->currentMicrofinance['name'] . ' Ninakubali kuwa ' . strtoupper($this->currentMicrofinance['name']) . ' inaweza kuchukua hatua za kisheria au za kimahakama dhidi yangu ikiwa sitatimiza majukumu yangu ya kifedha kwa ' . strtoupper($this->currentMicrofinance['name']) . '.</p>');
                $mpdf->WriteHTML('<p>Sahihi ya Mkopaji:____________________________</p>');
                $mpdf->WriteHTML('<h3>5.TAARIFA ZA MDHAMINI</h3>');
                //mdhamini
                $mpdf->WriteHTML('<p>Jina Kamili: ' . $wadhamin[0]['full_name'] . ' ' . $wadhamin[0]['full_name'] . '</p>');
                $mpdf->WriteHTML('<p>Simu: ' . $wadhamin[0]['phone'] . ' </p>');
                $mpdf->WriteHTML('<p>Sahihi ya Mdhamini:____________________________</p>');
                $mpdf->WriteHTML('<h3>6.Kwa matumizi ya ofisi</h3>');
                //matumizi ya ofisi
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
                $mpdf->OutputHttpDownload('Barua_ya_' . strtoupper($mokopajiInfo['full_name'] . '_' . $mokopajiInfo['middle_name'] . '_' . $mokopajiInfo['last_name']) . '.pdf');
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    //futa mkopo
    public function futaMkopo($id)
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
            $mokoId =  $this->shared->simpleDecrypt(base64_decode($id));
                $mokoId = $this->shared->cleanVar($mokoId);
            if (is_numeric($mokoId)) {
                $taarifaZamkopo = $this->model->where('id', $mokoId, true)->first();
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
                $malipo =  $model->getMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                $jumlailolipwa = $model->getTotalMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                if ($taarifaZamkopo['application_status']  == "Accepted" || $taarifaZamkopo['application_status']  != "Pending") {
                    return redirect()->back()->with('error', "Sahamani haunaidhini ya kufuta taarifa za mkopo huu");
                } else {
                    if ($taarifaZamkopo['payment_amount'] != $taarifaZamkopo['unpaid_amount']) {
                        return redirect()->back()->with('error', "Sahamani haunaidhini ya kufuta taarifa za mkopo huu");
                    } else {
                        $num = (!empty($malipo) && is_array($malipo)) ? count($malipo) : 0;
                        if ($num < 1) {
                            if ($this->model->delete($taarifaZamkopo['id'])) {
                                return redirect()->to('/orodhayamikopo');
                            } else {
                                return redirect()->back()->with('error', "Sahamani haunaidhini ya kufuta taarifa za mkopo huu");
                            }
                        } else {
                            return redirect()->back()->with('error', "Sahamani haunaidhini ya kufuta taarifa za mkopo huu");
                        }
                    }
                }
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    public function thibitishaMkopo($id)
    {
        $id = $id;
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('afisa_mkopo');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mokoId =  $this->shared->simpleDecrypt(base64_decode($id));
                $mokoId = $this->shared->cleanVar($mokoId);
            if (is_numeric($mokoId)) {
                $taarifaZamkopo = $this->model->where('id', $mokoId, true)->first();
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
                $malipo =  $model->getMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                $jumlailolipwa = $model->getTotalMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                if ($taarifaZamkopo['application_status']  == "Accepted" || $taarifaZamkopo['application_status']  != "Pending") {
                    return redirect()->back()->with('error', "Sahamani mkopo huu umekwisha idhinishwa");
                } else {
                    if ($taarifaZamkopo['payment_amount'] != $taarifaZamkopo['unpaid_amount']) {
                        return redirect()->back()->with('error', "Sahamani mkopo huu umekwisha idhinishwa");
                    } else {
                        $num = (!empty($malipo) && is_array($malipo)) ? count($malipo) : 0;
                        if ($num < 1) {
                            $this->model->setAllowedFields(['application_status']);
                            $data = ['application_status' => "Accepted"];
                            if ($this->model->update($taarifaZamkopo['id'], $data)) {
                                return redirect()->back()->with('ujumbe', "Mkopo umedhinishwa kikamilifu. Tafadahili hakikisha kua mteja amekabidhiwa fedha taslimu kulingana na kiasi alichokopa siku ya leo");
                            }
                        } else {
                            return redirect()->back()->with('error', "Sahamani mkopo huu umekwisha idhinishwa");
                        }
                    }
                }
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }

    //tamzamalipo
    public function tazamaMalipo($id)
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
            $mokoId =  $this->shared->simpleDecrypt(base64_decode($id));
                $mokoId = $this->shared->cleanVar($mokoId);
            if (is_numeric($mokoId)) {
                $taarifaZamkopo = $this->model->where('id', $mokoId, true)->first();
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
                $malipo =  $model->getMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                $jumlailolipwa = $model->getTotalMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                $data['mkopaji'] = $mokopajiInfo;
                $data['wadhmaini'] = $wadhamin;
                $data['taarifaZamkopo'] = $taarifaZamkopo;
                $data['malipo_ya_kopo'] = $malipo;
                $data['jumla_kalipa'] = $jumlailolipwa;
                $data['microfinance'] = $this->currentMicrofinance;

                return  view('app_head', $data) . view($this->currentpage . 'tazama_malipo') . view('app_footer');
            } else {
                throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
            }
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    //orodha ya mikopo
    public function orodhaYaMikopo()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mikopo = $this->model->leteMikopYote($this->currentMicrofinance['id']);
            $data['mikopo'] = $mikopo;
            return  view('app_head', $data) . view($this->currentpage . 'orodha') . view('app_footer');
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    //orodha ya mikopo haijamalizika
    public function orodhaYaMikopoHajimalizika()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mikopo = $this->model->leteMikopHaijamalizika($this->currentMicrofinance['id']);
            $data['mikopo'] = $mikopo;
            return  view('app_head', $data) . view($this->currentpage . 'orodha') . view('app_footer');
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    //orodha ya mikopo haijalipwa
    public function orodhaYaMikopoHajalipwa()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mikopo = $this->model->leteMikoHaijalipwa($this->currentMicrofinance['id']);
            $data['mikopo'] = $mikopo;
            return  view('app_head', $data) . view($this->currentpage . 'orodha') . view('app_footer');
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    //mikopp pendign
    public function orodhaYaMikopoPending()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mikopo = $this->model->leteMikopPending($this->currentMicrofinance['id']);
            $data['mikopo'] = $mikopo;
            return  view('app_head', $data) . view($this->currentpage . 'orodha') . view('app_footer');
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    //mikopp pitiliza
    public function orodhaYaMikopoPitiliza()
    {
        $acl = new AclContoller;
        $acl->ruhusu('mhasibu');
        $acl->ruhusu('meneja');
        $acl->ruhusu('mapokezi');
        $acl->ruhusu('mkusanyaji');
        $acl->ruhusu('afisa_mkopo');
        $acl->kwenyepage($this->currentpage . 'orodha');
        $acl->addPerm('add');
        if ($acl->amerusiwa($this->currentUser['system_role'], $this->currentpage . 'orodha', 'add')) {
            $mikopo = $this->model->leteMikopIlopitiliza($this->currentMicrofinance['id']);
            $data['mikopo'] = $mikopo;
            return  view('app_head', $data) . view($this->currentpage . 'orodha') . view('app_footer');
        } else {
            return view('app_head') . view('notfound') . view('app_footer');
        }
    }
    //LIPA MKOPO
    public function lipaMkopo()
    {
        $rules   = [
            'paymentAmount'=>'required|integer|max_length[9]|is_natural_no_zero|greater_than_equal_to[10]',
            'nakubali'=>'required',
            'msimbo'=>'required|min_length[4]|integer|max_length[4]',
            'loanId'=>'required|min_length[10]',
            'userId'=>'required|min_length[10]',
            'remainingAmount'=>'required|min_length[10]',
            'microfinanceId'=>'required|min_length[10]'
        ];
        if ($this->validate($rules)) {
            $post = $this->request->getPost(['paymentAmount','msimbo','loanId','userId','remainingAmount','microfinanceId']);
            $id = $post['loanId'];
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
                $mokoId = $this->shared->cleanVar($mokoId);
                if (is_numeric($mokoId)) {
                    $taarifaZamkopo = $this->model->where('id', $mokoId, true)->first();
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
                    $malipo =  $model->getMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                    $jumlailolipwa = $model->getTotalMalipo($mokopajid, $mokoId, $this->currentMicrofinance['id']);
                    $data['mkopaji'] = $mokopajiInfo;
                    $data['wadhmaini'] = $wadhamin;
                    $data['taarifaZamkopo'] = $taarifaZamkopo;
                    $data['malipo_ya_kopo'] = $malipo;
                    $data['jumla_kalipa'] = $jumlailolipwa;

                    if($this->shared->simpleDecrypt(base64_decode($post['microfinanceId'])) != $this->currentMicrofinance['id']){
                        
                        $model = new FailedLogins();
                        $ip = $this->request->getIPAddress();
                        $model->temporaryBan($ip);
                        $fail_attemps = $model->get_count_atempts($ip);
                        $num = $fail_attemps['num'];
                        if ($num >= 5) {
                            return redirect()->to('/ondoka');
                        }else{
                            return redirect()->back()->with('error',"uwasilishaji wa fomu usio salama umegunduliwa. Tafadhali hakikisha kuwa umeidhinishwa kufanya kitendo hiki na ni halali mfId");
                        }
                        
                    }elseif($this->shared->simpleDecrypt(base64_decode($post['remainingAmount'])) != $taarifaZamkopo['unpaid_amount']){
                        $model = new FailedLogins();
                        $ip = $this->request->getIPAddress();
                        $model->temporaryBan($ip);
                        $fail_attemps = $model->get_count_atempts($ip);
                        $num = $fail_attemps['num'];
                        if ($num >= 5) {
                            return redirect()->to('/ondoka');
                        }else{
                            return redirect()->back()->with('error',"uwasilishaji wa fomu usio salama umegunduliwa. Tafadhali hakikisha kuwa umeidhinishwa kufanya kitendo hiki na ni halali unp");
                        }
                    }elseif($this->shared->simpleDecrypt(base64_decode($post['userId'])) != $taarifaZamkopo['client_id']){
                        $model = new FailedLogins();
                        $ip = $this->request->getIPAddress();
                        $model->temporaryBan($ip);
                        $fail_attemps = $model->get_count_atempts($ip);
                        $num = $fail_attemps['num'];
                        if ($num >= 5) {
                            return redirect()->to('/ondoka');
                        }else{
                            return redirect()->back()->with('error',"uwasilishaji wa fomu usio salama umegunduliwa. Tafadhali hakikisha kuwa umeidhinishwa kufanya kitendo hiki na ni halali uid");
                        }
                    }else{
                        if($taarifaZamkopo['kiasi_kwa_awamu']>$post['paymentAmount']){
                            if($taarifaZamkopo['unpaid_amount']<$taarifaZamkopo['kiasi_kwa_awamu']){
                                //lipa
                                if($post['paymentAmount']>$taarifaZamkopo['unpaid_amount']){
                                    return redirect()->back()->with('error',"Kiwango cha malipo kimezidi. deni linalodaiwa  ni ".$this->shared->to_currency($taarifaZamkopo['unpaid_amount'],'sw-Tz')." kiasi ulicholipa ni ".$this->shared->to_currency($post['paymentAmount'],'sw-TZ')." Tafadhali ingiza kiwango sahihi ilikuweza kuendelea");
                                }else{
                                    //lipa
                                    $model = new MalipoModel();
                                    $model->setAllowedFields(['payment_amount','loan_id','client_id','remaining_amount','microfinance_id','imepokelewa_na']);
                                    $data = [
                                        'payment_amount'=>$post['paymentAmount'],
                                        'loan_id'=>$taarifaZamkopo['id'],
                                        'client_id'=>$taarifaZamkopo['client_id'],
                                        'remaining_amount'=>$taarifaZamkopo['unpaid_amount']-$post['paymentAmount'],
                                        'microfinance_id'=>$this->currentMicrofinance['id'],
                                        'imepokelewa_na'=>$this->currentUser['id']
                                    ];
                                    if($model->save($data)){
                                        $this->model->setAllowedFields(['unpaid_amount']);
                                        $data = [
                                            'unpaid_amount'=>$taarifaZamkopo['unpaid_amount']-$post['paymentAmount'],
                                        ];
                                        if($this->model->update($taarifaZamkopo['id'],$data)){
                                            //savw log
                                            return redirect()->back()->with('ujumbe',"malipo yamechakatwa. Kiasi kilicholipwa ni ".$this->shared->to_currency($post['paymentAmount'],'sw-Tz')." kiasi ambacho kimesaliani ".$this->shared->to_currency($data['unpaid_amount'],'sw-Tz'));
                                        }else{
                                            return redirect()->back()->with('error',"Tatizo limejitokeza wakati wa kuhifadi malipo tafadhali jaribu tena kama tatizo litaendelea tafadhali wasiliana na msanidi wa programu");
                                        }
                                    }else{
                                        return redirect()->back()->with('error',"Tatizo limejitokeza wakati wa kuhifadi malipo tafadhali jaribu tena kama tatizo litaendelea tafadhali wasiliana na msanidi wa programu");
                                    }
                                }
                            }else{
                                return redirect()->back()->with('error',"Kiwango cha malipo kipo chini ya kiwango kinachotakiwa kulipwa kwa awamu. Malipo ya kila ".$taarifaZamkopo['kulipa_kwa_kila']." ni ".$this->shared->to_currency($taarifaZamkopo['kiasi_kwa_awamu'],'sw-Tz')." kiasi ulicholipa ni ".$this->shared->to_currency($post['paymentAmount'],'sw-TZ')." Tafadhali ingiza kiwango sahihi ilikuweza kuendelea");
                            }
                        }else{
                            //lipa
                            if($post['paymentAmount'] > $taarifaZamkopo['unpaid_amount']){
                                return redirect()->back()->with('error',"Kiwango cha malipo kimezidi. deni linalodaiwa ni ".$this->shared->to_currency($taarifaZamkopo['unpaid_amount'],'sw-Tz')." kiasi ulicholipa ni ".$this->shared->to_currency($post['paymentAmount'],'sw-TZ')." Tafadhali ingiza kiwango sahihi ilikuweza kuendelea");
                            }else{
                                //lipa
                                $model = new MalipoModel();
                                    $model->setAllowedFields(['payment_amount','loan_id','client_id','remaining_amount','microfinance_id','imepokelewa_na']);
                                    $data = [
                                        'payment_amount'=>$post['paymentAmount'],
                                        'loan_id'=>$taarifaZamkopo['id'],
                                        'client_id'=>$taarifaZamkopo['client_id'],
                                        'remaining_amount'=>$taarifaZamkopo['unpaid_amount']-$post['paymentAmount'],
                                        'microfinance_id'=>$this->currentMicrofinance['id'],
                                        'imepokelewa_na'=>$this->shared->decrypt(base64_decode(session()->get('USER_ID')))
                                    ];
                                    if($model->save($data)){
                                        $this->model->setAllowedFields(['unpaid_amount']);
                                        $data = [
                                            'unpaid_amount'=>$taarifaZamkopo['unpaid_amount']-$post['paymentAmount'],
                                        ];
                                        
                                        if($this->model->update($taarifaZamkopo['id'],$data)){
                                            //savw log
                                            return redirect()->back()->with('ujumbe',"malipo yamechakatwa. Kiasi kilicholipwa ni ".$this->shared->to_currency($post['paymentAmount'],'sw-Tz')." kiasi ambacho kimesalia ni ".$this->shared->to_currency($data['unpaid_amount'],'sw-Tz'));
                                        }else{
                                            return redirect()->back()->with('error',"Tatizo limejitokeza wakati wa kuhifadi malipo tafadhali jaribu tena kama tatizo litaendelea tafadhali wasiliana na msanidi wa programu");
                                        }
                                    }else{
                                        return redirect()->back()->with('error',"Tatizo limejitokeza wakati wa kuhifadi malipo tafadhali jaribu tena kama tatizo litaendelea tafadhali wasiliana na msanidi wa programu");
                                    }
                            }
                        }
                    }
                } else {
                    throw new PageNotFoundException("hatukuweza kupata mtumiaji unayemtafuta");
                }
            } else {
                return view('app_head') . view('notfound') . view('app_footer');
            }
        } else {
            return redirect()->back()->withInput();
        }
    }
}
