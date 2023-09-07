<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LoginContoller extends BaseController
{
    public function index()
    {
        return view('login').view('app_footer');
    }
}
