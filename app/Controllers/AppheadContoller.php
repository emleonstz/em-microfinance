<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AppheadContoller extends BaseController
{
    private $shared;
    public function __construct()
    {
        $this->shared = new SharedControler;
    }
    public function index()
    {
        //
    }
    function getMicrofinance(){
        $current =  $this->shared->get_user_microfinance();
        return $current;
    }
}
