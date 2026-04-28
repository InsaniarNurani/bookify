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
        'alamat'

    ];
    public function getAll()
    {
        return $this->db->table('peminjaman')
            ->select('
            peminjaman.*,
            users.nama AS nama_anggota
        ')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
            ->join('users', 'users.id = anggota.user_id')
            ->orderBy('peminjaman.id_peminjaman', 'DESC')
            ->get()
            ->getResultArray();
    }
    public function getByAnggota($id)
    {
        return $this->db->table('peminjaman')
            ->select('
            peminjaman.*,
            users.nama AS nama_anggota
        ')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
            ->join('users', 'users.id = anggota.user_id')
            ->where('peminjaman.id_anggota', $id)
            ->orderBy('peminjaman.id_peminjaman', 'DESC')
            ->get()
            ->getResultArray();
    }
}
