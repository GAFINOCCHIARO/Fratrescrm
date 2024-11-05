<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\EmailManager;
use Config\Encryption;

class Prova extends BaseController
{
    public $key;
    public function index()
    {
        $hexKey = bin2hex(random_bytes(16));
        echo "Chiave letta da .env: " . $hexKey.'<br>'; // Questo mostra la chiave letta

        
    }
}
