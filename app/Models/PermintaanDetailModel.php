<?php

namespace App\Models;

use CodeIgniter\Model;

class PermintaanDetailModel extends Model
{
    protected $table            = 'permintaan_detail';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'permintaan_id',
        'bahan_id',
        'jumlah_diminta'
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [

    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    // Relationships
    public function getDetailWithBahan($permintaanId)
    {
        return $this->db->table($this->table)
                       ->select('permintaan_detail.*, bahan_baku.nama as bahan_nama, bahan_baku.satuan, bahan_baku.jumlah as stok_tersedia')
                       ->join('bahan_baku', 'bahan_baku.id = permintaan_detail.bahan_id')
                       ->where('permintaan_detail.permintaan_id', $permintaanId)
                       ->get()
                       ->getResultArray();
    }
}