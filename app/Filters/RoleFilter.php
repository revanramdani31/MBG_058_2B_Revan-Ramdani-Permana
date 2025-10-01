<?php


namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('msg', 'Silakan login terlebih dahulu');
        }

        $userRole = session()->get('user_role');
        
        if ($arguments && !empty($arguments)) {
            $requiredRoles = $arguments;
            
            if (!in_array($userRole, $requiredRoles)) {
                session()->setFlashdata('msg', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman ini.');
                
                if ($userRole == 'gudang') {
                    return redirect()->to('/gudang/dashboard');
                } elseif ($userRole == 'dapur') {
                    return redirect()->to('/dapur/dashboard');
                } else {
                    return redirect()->to('/dashboard');
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}