<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrderModel;

class UserController extends BaseController
{
    protected UserModel        $userModel;
    protected OrderModel       $orderModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->orderModel   = new OrderModel();
    }

    // ─── GET /profile ─────────────────────────────────────────────────────────────
    public function profile(): string
    {
        $userId = session()->get('user_id');
        $user   = $this->userModel->find($userId);
        $orders = $this->orderModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->limit(5)->findAll();

        return view('user/profile', compact('user', 'orders'));
    }

    // ─── GET /profile/edit ────────────────────────────────────────────────────────
    public function editProfile(): string
    {
        $userId = session()->get('user_id');
        $user   = $this->userModel->find($userId);
        return view('user/profile_edit', compact('user'));
    }

    // ─── POST /profile/edit ───────────────────────────────────────────────────────
    public function updateProfile()
    {
        $userId = session()->get('user_id');
        $rules = [
            'name'  => 'required|min_length[2]|max_length[100]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (!$this->validate($rules)) {
            $user = $this->userModel->find($userId);
            return view('user/profile_edit', ['user' => $user, 'errors' => $this->validator->getErrors()]);
        }

        $this->userModel->update($userId, [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
        ]);

        session()->set('user_name', $this->request->getPost('name'));
        session()->set('user_email', $this->request->getPost('email'));

        session()->setFlashdata('success', 'Profile updated successfully.');
        return redirect()->to('/profile');
    }

    // ─── POST /profile/password ───────────────────────────────────────────────────
    public function updatePassword()
    {
        $userId = session()->get('user_id');
        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', implode('<br>', $this->validator->getErrors()));
            return redirect()->back();
        }

        $user = $this->userModel->find($userId);
        if (!password_verify($this->request->getPost('current_password'), (string) $user['password'])) {
            session()->setFlashdata('error', 'Current password is incorrect.');
            return redirect()->back();
        }

        $this->userModel->update($userId, ['password' => $this->request->getPost('new_password')]);
        session()->setFlashdata('success', 'Password updated successfully.');
        return redirect()->to('/profile');
    }

}

