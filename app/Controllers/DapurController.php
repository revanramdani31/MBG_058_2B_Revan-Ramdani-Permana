<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BahanBakuModel;
use App\Models\PermintaanModel;
use App\Models\PermintaanDetailModel;

class DapurController extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (session()->get('user_role') !== 'dapur') {
            return redirect()->to('/login')->with('error', 'Akses ditolak!');
        }

        return view('dapur/dashboard');
    }

    public function createPermintaan()
    {
        $bahanBakuModel = new BahanBakuModel();
        $bahan_baku = $bahanBakuModel->where('jumlah >', 0)
            ->where('status !=', 'kadaluarsa')
            ->findAll();

        return view('dapur/create_permintaan', ['bahan_baku' => $bahan_baku]);
    }

    public function storePermintaan()
    {
        $rules = [
            'tanggal_masak' => 'required|valid_date',
            'menu_makan' => 'required|string',
            'jumlah_porsi' => 'required|numeric|greater_than[0]',
            'bahan_id.*' => 'required|numeric',
            'jumlah.*' => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $permintaanModel = new PermintaanModel();
        $permintaanDetailModel = new PermintaanDetailModel();

        $permintaanData = [
            'pemohon_id' => session()->get('user_id'), // <-- Tambahkan ini
            'tgl_masak' => $this->request->getPost('tanggal_masak'),
            'menu_makan' => $this->request->getPost('menu_makan'),
            'jumlah_porsi' => $this->request->getPost('jumlah_porsi'),
            'status' => 'menunggu',
            'created_at' => date('Y-m-d H:i:s'), // <-- Tambahkan ini
        ];

        $permintaanId = $permintaanModel->insert($permintaanData);

        $bahanIds = $this->request->getPost('bahan_id');
        $jumlahs = $this->request->getPost('jumlah');

        foreach ($bahanIds as $index => $bahanId) {
            $detailData = [
                'permintaan_id' => $permintaanId,
                'bahan_id' => $bahanId,
                'jumlah_diminta' => $jumlahs[$index],
            ];
            $permintaanDetailModel->insert($detailData);
        }

        return redirect()->to('/dapur/dashboard')->with('success', 'Permintaan bahan baku berhasil dibuat.');
    }
}