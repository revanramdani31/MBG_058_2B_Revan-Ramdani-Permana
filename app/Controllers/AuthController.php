<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (session()->get('isLoggedIn')) {
            $role = session()->get('user_role');
            if ($role == 'gudang') {
                return redirect()->to('/gudang/dashboard');
            } elseif ($role == 'dapur') {
                return redirect()->to('/dapur/dashboard');
            }
        }

        return view('auth/login');
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            if (empty($email) || empty($password)) {
                return redirect()->back()->with('error', 'Email dan password harus diisi!');
            }
            $user = $this->userModel->where('email', $email)->first();


            if ($user && $user['password'] === md5($password)) {
                session()->set([
                    'isLoggedIn' => true,
                    'user_id' => $user['id'],
                    'user_name' => $user['name'],
                    'user_email' => $user['email'],
                    'user_role' => $user['role'],
                ]);

                if ($user['role'] === 'gudang') {
                    return redirect()->to('/gudang/dashboard');
                } else {
                    return redirect()->to('/dapur/dashboard');
                }
            } else {
                return redirect()->back()->with('error', 'Email atau password yang Anda masukkan salah.');
            }
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}