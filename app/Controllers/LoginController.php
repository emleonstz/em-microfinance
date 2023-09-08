<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FailedLogins;
use App\Models\UsersModel;
use App\Controllers\SharedControler;

class LoginController extends BaseController
{
    private $shared;
    private $session;
    public function __construct()
    {
        $this->shared  = new SharedControler;
        $this->session = session();
    }
    public function index()
    {
        $model = new FailedLogins();
        $ip = $this->request->getIPAddress();
        $data['state'] = null;
        $fail_attemps = $model->get_count_atempts($ip);
        if (!empty($fail_attemps) && is_array($fail_attemps)) {
            $num = $fail_attemps['num'];
            if ($num >= 5) {
                $lastAtempt = $model->getLastAttempt($ip);
                $currentTime = time();
                $lasttime = $lastAtempt['enable_after'];
                if ($lasttime > $currentTime) {
                    $data['state'] = ['ban' => $lasttime - $currentTime];
                } else {
                    $model->unBan($ip);
                    $data['state'] = null;
                }
            }
        }
        return view('login', $data) . view('app_footer');
    }

    public function login()
    {
        $sessionData  = [
            'fail_attemps' => null,
        ];
        
        $rules = [
            'email'        => 'required|max_length[254]|valid_email',
            'password'     => 'required|max_length[100]|min_length[6]',
        ];
        if ($this->validate($rules)) {
            $post = $this->request->getPost(['email', 'password']);
            $model = new UsersModel();
            $user = $model->where('email', $post['email'], true)->first();
            if (!empty($user) && is_array($user)) {
                $hash = $user['password'];
                if (password_verify($post['password'], $hash)) {
                    if ($user['accout_status'] === "Active") {
                        $ses_data = [
                            'USER_ID' => base64_encode($this->shared->encrypt($user['id'])),
                            'USER_EMAIL' => $user['email'],
                            'USER_FIRSTNAME' => $user['first_name'],
                            'USER_LASTNAME' => $user['last_name'],
                            'USER_PHOTO' => $user['photo'],
                            'USER_PHONE' => $user['phone'],
                            'USER_APIKEY' => $user['api_key'],
                            'TIMEOUT' => base64_encode($this->shared->encrypt($user['api_key'])),

                        ];
                        $this->session->set($ses_data);
                        

                    } else {
                        $model = new FailedLogins();
                        $ip = $this->request->getIPAddress();
                        $model->temporaryBan($ip);
                        $fail_attemps = $model->get_count_atempts($ip);
                        $num = $fail_attemps['num'];
                        if ($num >= 5) {
                            return redirect()->back()->with('ban', "majaribio mengi sana ya kuingia ambayo hayakufaulu akaunti yako imepigwa marufuku kwa muda tafadhali jaribu tena baada ya muda mfupi");
                        } else {
                            return redirect()->back()->with('error', "Akaunti yako haijawashwa tafadhali wasiliana na msimamizi");
                        }
                    }
                } else {
                    $model = new FailedLogins();
                    $ip = $this->request->getIPAddress();
                    $model->temporaryBan($ip);
                    $fail_attemps = $model->get_count_atempts($ip);
                    $num = $fail_attemps['num'];
                    if ($num >= 5) {
                        return redirect()->back()->with('ban', "majaribio mengi sana ya kuingia ambayo hayakufaulu akaunti yako imepigwa marufuku kwa muda tafadhali jaribu tena baada ya muda mfupi");
                    } else {
                        return redirect()->back()->with('error', "jina la mtumiaji au nenosiri batili");
                    }
                }
            } else {
                $model = new FailedLogins();
                $ip = $this->request->getIPAddress();
                $model->temporaryBan($ip);
                $fail_attemps = $model->get_count_atempts($ip);
                $num = $fail_attemps['num'];
                if ($num >= 5) {
                    return redirect()->back()->with('ban', "majaribio mengi sana ya kuingia ambayo hayakufaulu akaunti yako imepigwa marufuku kwa muda tafadhali jaribu tena baada ya muda mfupi");
                } else {
                    return redirect()->back()->with('error', "jina la mtumiaji au nenosiri batili");
                }
            }
        } else {
            $model = new FailedLogins();
            $ip = $this->request->getIPAddress();
            $model->temporaryBan($ip);
            $fail_attemps = $model->get_count_atempts($ip);
            $num = $fail_attemps['num'];
            if ($num >= 5) {
                return redirect()->back()->with('ban', "majaribio mengi sana ya kuingia ambayo hayakufaulu akaunti yako imepigwa marufuku kwa muda tafadhali jaribu tena baada ya muda mfupi");
            } else {
                return redirect()->back()->withInput();
            }
        }
    }
    public function logout() {
        $this->session->destroy();
        return redirect()->to('/login');
        exit();
    }
}
