<?php

namespace App\Filters;

use App\Libraries\JwtHelper;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // ── 1. Check session (primary) ────────────────────────────────────────────
        if (session()->get('logged_in') === true) {
            return; // already authenticated via session
        }

        // ── 2. Fall back to JWT cookie ────────────────────────────────────────────
        $token   = get_cookie('access_token');
        $jwt     = new JwtHelper();
        $decoded = $token ? $jwt->decode($token) : null;

        if ($decoded) {
            // Restore session from JWT so downstream code works
            session()->set([
                'user_id'   => $decoded->user_id,
                'user_email'=> $decoded->email,
                'user_role' => $decoded->role,
                'logged_in' => true,
            ]);
            return;
        }

        // ── 3. Reject ─────────────────────────────────────────────────────────────
        session()->setFlashdata('error', 'Please log in to continue.');
        return redirect()->to(site_url('login'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): void
    {
        // nothing
    }
}