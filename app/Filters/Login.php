<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Login implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $auth = service('auth');
        $user = $auth->user();

        if (!$user) {
            return redirect()->to('login');
        }

        if ($arguments) {
            foreach ($arguments as $permission) {
                if (!$user->can($permission)) {
                      return redirect()->to('no_permission')->with('error', 'Non hai i permessi per accedere a questa funzione.');;
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here if needed
    }

   
}
