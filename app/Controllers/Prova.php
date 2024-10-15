<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\EmailManager;

class Prova extends BaseController
{
    public function index()
    {
     $emailManager = new EmailManager();
            $emailManager->getMessage('exsamconfirm',5,51);   
    }
}
