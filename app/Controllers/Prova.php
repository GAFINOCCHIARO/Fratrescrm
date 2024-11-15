<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\PrivacyController as privacycontroller;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\EmailManager;
use Config\Encryption;

class Prova extends BaseController
{
    public $key;
    public function index()
    {
        $pp=new privacycontroller();
        $pp->Savenewconsent(87,30);

        
    }
}
