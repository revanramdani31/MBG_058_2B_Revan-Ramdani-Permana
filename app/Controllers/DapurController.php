<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DapurController extends BaseController
{
    public function index()
    {
        $data = [
            'user_name' => session()->get('user_name'),
            'user_role' => session()->get('user_role'),
            'user_email' => session()->get('user_email')
        ];
        
        return view('dapur/dashboard', $data);
    }
}