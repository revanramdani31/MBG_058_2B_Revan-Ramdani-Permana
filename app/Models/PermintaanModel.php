<?php

namespace App\Models;

use CodeIgniter\Model;

class PermintaanModel extends Model
{
    protected $table            = 'permintaan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'pemohon_id',
        'tgl_masak',
        'menu_makan',
        'jumlah_porsi',
        'status',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    // Validation
    protected $validationRules      = [

    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setCreatedAt'];
    
    protected function setCreatedAt(array $data)
    {
        if (!isset($data['data']['created_at'])) {
            $data['data']['created_at'] = date('Y-m-d H:i:s');
        }
        return $data;
    }

    // Relationships
    public function getPemohon($id)
    {
        return $this->db->table($this->table)
                       ->select('permintaan.*, user.name as pemohon_name, user.email as pemohon_email')
                       ->join('user', 'user.id = permintaan.pemohon_id')
                       ->where('permintaan.id', $id)
                       ->get()
                       ->getRowArray();
    }
}