<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class GudangController extends BaseController
{
    public function index() 
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (session()->get('user_role') !== 'gudang') {
            return redirect()->to('/login')->with('error', 'Akses ditolak!');
        }

        return view('gudang/dashboard');
    }
}