<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\JwtHelper;

class AuthController extends BaseController
{
    protected UserModel $userModel;
    protected JwtHelper $jwt;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->jwt       = new JwtHelper();
        helper('cookie');
    }

    // ─── GET /register ──────────────────────────────────────────────────────────
    public function registerForm()
    {
        if (session()->get('user_id')) {
            return redirect()->to(site_url('shop'));
        }
        return view('auth/register');
    }

    // ─── POST /register ─────────────────────────────────────────────────────────
    public function register()
    {
        $rules = [
            'name'             => 'required|min_length[2]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return view('auth/register', ['errors' => $this->validator->getErrors()]);
        }

        $this->userModel->insert([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role'     => 'customer',
        ]);

        session()->setFlashdata('success', 'Account created! Please log in.');
        return redirect()->to(site_url('login'));
    }

    // ─── GET /login ─────────────────────────────────────────────────────────────
    public function loginForm()
    {
        if (session()->get('user_id')) {
            return redirect()->to(site_url('shop'));
        }
        return view('auth/login');
    }

    // ─── POST /login ─────────────────────────────────────────────────────────────
    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return view('auth/login', ['error' => 'Invalid email or password.']);
        }

        // ── Session ──────────────────────────────────────────────────────────────
        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
            'logged_in'  => true,
        ]);

        // ── JWT Cookie ───────────────────────────────────────────────────────────
        $token = $this->jwt->generate([
            'user_id' => $user['id'],
            'email'   => $user['email'],
            'role'    => $user['role'],
        ]);

        $this->response->setCookie([
            'name'     => 'access_token',
            'value'    => $token,
            'expire'   => $this->jwt->getTtl(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        $redirect = $user['role'] === 'admin' ? site_url('admin/dashboard') : site_url('shop');
        return redirect()->to($redirect);
    }

    // ─── GET /logout ─────────────────────────────────────────────────────────────
    public function logout()
    {
        session()->destroy();
        delete_cookie('access_token');
        return redirect()->to(site_url('login'));
    }
}