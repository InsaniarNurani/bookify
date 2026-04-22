<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $allowedFields = [
        'id_anggota',
        'id_petugas',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'metode_pengantaran',
        'status_pengiriman'
    ];

    // ================= GET ALL =================
    public function getAll($keyword = null, $userId = null, $role = null)
    {
        $builder = $this->db->table('peminjaman');

        $builder->select('peminjaman.*, anggota.user_id');
        $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota');

        if ($role == 'anggota' && $userId) {
            $builder->where('peminjaman.id_anggota', $userId);
        }

        if ($keyword) {
            $builder->like('anggota.user_id', $keyword);
        }

        return $builder->get()->getResultArray();
    }
}
