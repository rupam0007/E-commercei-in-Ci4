<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Please log in to continue.');
            return redirect()->to(site_url('login'));
        }

        if (session()->get('user_role') !== 'admin') {
            session()->setFlashdata('error', 'Access denied.');
            return redirect()->to(site_url('shop'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): void
    {
        // nothing
    }
}
