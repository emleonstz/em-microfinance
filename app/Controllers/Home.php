<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('app_head') .view('collection_officer').view('app_footer');
    }
}
