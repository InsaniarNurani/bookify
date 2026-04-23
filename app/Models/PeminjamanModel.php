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
        'status_pengiriman',
        'lama_perpanjangan' // 🔥 TAMBAH INI WAJIB
    ];

    // ================= GET ALL =================
    public function getAll($keyword = null, $userId = null, $role = null)
    {
        $builder = $this->db->table('peminjaman');

        $builder->select('peminjaman.*, users.nama as nama_anggota');
        $builder->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota');
        $builder->join('users', 'users.id = anggota.user_id');

        if ($role == 'anggota' && $userId) {
            $builder->where('peminjaman.id_anggota', $userId);
        }

        if ($keyword) {
            $builder->like('users.nama', $keyword);
        }

        return $builder->get()->getResultArray();
    }
    // ================= UPDATE STATUS =================
    public function updateStatus($id, $status)
    {
        return $this->update($id, [
            'status' => $status
        ]);
    }

    // ================= PERPANJANG =================
    public function perpanjang($id, $hari)
    {
        return $this->update($id, [
            'status' => 'diperpanjang',
            'lama_perpanjangan' => $hari
        ]);
    }
}
