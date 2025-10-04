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

        $model = new \App\Models\BahanBakuModel();
        $items = $model->findAll();

        foreach ($items as &$row) {
            $computed = 'Tersedia';

            if (isset($row['jumlah']) && (int)$row['jumlah'] <= 0) {
                $computed = 'Habis';
            } else {

                if (!empty($row['tanggal_kadaluarsa'])) {
                    $tgl = strtotime($row['tanggal_kadaluarsa']);
                    $now = time();
                    $diffDays = floor(($tgl - $now) / (60 * 60 * 24));

                    if ($diffDays <= 0) {
                        $computed = 'Kadaluarsa';
                    } elseif ($diffDays <= 7) {
                        $computed = 'Segera Kadaluarsa';
                    }
                }
            }

            $row['computed_status'] = $computed;
        }

        return view('gudang/dashboard', [
            'items' => $items
        ]);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn') || session()->get('user_role') !== 'gudang') {
            return redirect()->to('/login')->with('error', 'Akses ditolak!');
        }

        return view('gudang/create_bahan');
    }

    public function store()
    {
        if (! $this->request->is('post')) {
            return redirect()->to('/gudang/bahan/create');
        }

        $rules = [
            'nama' => 'required|min_length[3]|max_length[255]',
            'kategori' => 'required|max_length[100]',
            'jumlah' => 'required|numeric',
            'satuan' => 'required|max_length[50]',
            'tanggal_masuk' => 'required|valid_date[Y-m-d]',
            'tanggal_kadaluarsa' => 'permit_empty|valid_date[Y-m-d]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $model = new \App\Models\BahanBakuModel();

        $data = [
            'nama' => $this->request->getPost('nama'),
            'kategori' => $this->request->getPost('kategori'),
            'jumlah' => $this->request->getPost('jumlah'),
            'satuan' => $this->request->getPost('satuan'),
            'tanggal_masuk' => $this->request->getPost('tanggal_masuk'),
            'tanggal_kadaluarsa' => $this->request->getPost('tanggal_kadaluarsa') ?: null,
            'status' => 'Tersedia',
            'created_at' => date('Y-m-d H:i:s')
        ];

        $model->insert($data);

        return redirect()->to('/gudang/dashboard')->with('success', 'Bahan baku berhasil ditambahkan.');
    }
    public function updateStockForm($id = null)
    {
        if (!session()->get('isLoggedIn') || session()->get('user_role') !== 'gudang') {
            return redirect()->to('/login')->with('error', 'Akses ditolak!');
        }

        $model = new \App\Models\BahanBakuModel();
        $item = $model->find($id);

        if (!$item) {
            return redirect()->to('/gudang/dashboard')->with('error', 'Data bahan baku tidak ditemukan.');
        }

        return view('gudang/update_stok', ['item' => $item]);
    }

    public function updateStock($id = null)
    {
        if (! $this->request->is('post')) {
            return redirect()->to('/gudang/dashboard');
        }

        if (!session()->get('isLoggedIn') || session()->get('user_role') !== 'gudang') {
            return redirect()->to('/login')->with('error', 'Akses ditolak!');
        }

        $model = new \App\Models\BahanBakuModel();
        $item = $model->find($id);

        if (!$item) {
            return redirect()->to('/gudang/dashboard')->with('error', 'Data bahan baku tidak ditemukan.');
        }

        $operasi = $this->request->getPost('operasi');
        $jumlahRaw = $this->request->getPost('jumlah');

        if (! in_array($operasi, ['tambah', 'kurang'], true)) {
            return redirect()->back()->with('error', 'Operasi tidak valid.')->withInput();
        }

        if ($jumlahRaw === null || $jumlahRaw === '' || ! is_numeric($jumlahRaw)) {
            return redirect()->back()->with('error', 'Jumlah harus berupa angka.')->withInput();
        }

        $jumlah = (int) $jumlahRaw;
        if ($jumlah < 0) {
            return redirect()->back()->with('error', 'Jumlah tidak boleh negatif.')->withInput();
        }

        $stokSaatIni = (int) ($item['jumlah'] ?? 0);
        $stokBaru = $operasi === 'tambah' ? ($stokSaatIni + $jumlah) : ($stokSaatIni - $jumlah);

        if ($stokBaru < 0) {
            return redirect()->back()->with('error', 'Stok akhir tidak boleh kurang dari 0.')->withInput();
        }

        $status = $stokBaru <= 0 ? 'Habis' : 'Tersedia';

        $model->update($id, [
            'jumlah' => $stokBaru,
            'status' => $status,
        ]);

        return redirect()->to('/gudang/dashboard')->with('success', 'Stok berhasil diperbarui.');
    }
}