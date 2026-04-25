<?php

namespace App\Models;

use CodeIgniter\Model;

class PenarikanModel extends Model
{
    protected $table = 'penarikan';
    protected $primaryKey = 'id_penarikan';
    protected $allowedFields = [
        'id_peminjaman',
        'alamat',
        'biaya',
        'status',
        'tanggal_ambil',
        'petugas_id'
    ];

    // 🔥 JOIN KE PEMINJAMAN + ANGGOTA
    public function getPenarikan()
    {
        return $this->db->table('penarikan')
            ->select('penarikan.*, users.nama as nama_anggota')
            ->join('peminjaman', 'peminjaman.id_peminjaman = penarikan.id_peminjaman')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
            ->join('users', 'users.id = anggota.user_id')
            ->get()
            ->getResultArray();
    }


    // 🔥 DETAIL
    public function getDetail($id)
    {
        return $this->db->table('penarikan')
            ->select('penarikan.*, anggota.nama as nama_anggota, users.nama as nama_petugas')
            ->join('peminjaman', 'peminjaman.id_peminjaman = penarikan.id_peminjaman')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
            ->join('users', 'users.id = penarikan.petugas_id', 'left')
            ->where('penarikan.id_penarikan', $id)
            ->get()
            ->getRowArray();
    }
}
