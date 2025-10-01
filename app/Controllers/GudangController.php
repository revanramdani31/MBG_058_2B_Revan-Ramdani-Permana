<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BahanBakuModel;

class GudangController extends BaseController
{
    protected $bahanBakuModel;

    public function __construct()
    {
        $this->bahanBakuModel = new BahanBakuModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');

        $builder = $this->bahanBakuModel;

        // Filter berdasarkan keyword
        if ($keyword) {
            $builder = $builder->groupStart()
                              ->like('nama', $keyword)
                              ->orLike('kategori', $keyword)
                              ->groupEnd();
        }

        // Filter berdasarkan status
        if ($status) {
            $builder = $builder->where('status', $status);
        }

        $bahan_baku = $builder->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'user_name' => session()->get('user_name'),
            'user_role' => session()->get('user_role'),
            'user_email' => session()->get('user_email'),
            'bahan_baku' => $bahan_baku,
            'title' => 'Dashboard Gudang - Manajemen Bahan Baku'
        ];
        
        return view('gudang/dashboard', $data);
    }
}