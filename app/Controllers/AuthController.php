<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index(){
        if (session()->get('isLoggedIn')) {
            $role = session()->get('user_role');
            if ($role == 'gudang') {
                return redirect()->to('/gudang/dashboard');
            } elseif ($role == 'dapur') {
                return redirect()->to('/dapur/dashboard');
            } else {
                return redirect()->to('/dashboard');
            }
        }

        return view('auth/login');
    }

    public function login()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $session = session();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            $ses_data = [
                'user_id'       => $user['id'],
                'user_name'     => $user['name'],
                'user_email'    => $user['email'],
                'user_role'     => $user['role'],
                'isLoggedIn'    => TRUE
            ];
            $session->set($ses_data);
            
            if ($user['role'] == 'gudang') {
                return redirect()->to('/gudang/dashboard');
            } elseif ($user['role'] == 'dapur') {
                return redirect()->to('/dapur/dashboard');
            } else {
                return redirect()->to('/dashboard');
            }
        } else {
            $session->setFlashdata('msg', 'Email atau password salah.');
            return redirect()->to('/login'); 
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login'); 
    }
}