<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $helpers = ['url', 'form'];

    public function initController(
    \CodeIgniter\HTTP\RequestInterface $request,
    \CodeIgniter\HTTP\ResponseInterface $response,
    \Psr\Log\LoggerInterface $logger
) {
    parent::initController($request, $response, $logger);

    if (session()->has('user_id')) {
        \Config\Database::connect()
            ->table('users')
            ->where('id', session()->get('user_id'))
            ->update([
                'last_seen' => date('Y-m-d H:i:s')
            ]);
    }
}

}
