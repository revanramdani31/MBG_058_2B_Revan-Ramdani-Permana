<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        if (is_array($arguments) && count($arguments) > 0) {
            $requiredRole = $arguments[0];
            $userRole = session()->get('user_role');

            if ($userRole !== $requiredRole) {
                $redirectTo = '/';
                if ($userRole === 'gudang') {
                    $redirectTo = '/gudang/dashboard';
                } elseif ($userRole === 'dapur') {
                    $redirectTo = '/dapur/dashboard';
                } else {
                    $redirectTo = '/';
                }
                return redirect()->to($redirectTo)->with('error', 'Anda tidak memiliki hak akses ke halaman ini');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}