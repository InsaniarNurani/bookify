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
            u1.nama as nama_anggota,
            u2.nama as nama_petugas
        ')

            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users as u1', 'u1.id = anggota.user_id', 'left')

            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
            ->join('users as u2', 'u2.id = petugas.user_id', 'left')

            ->orderBy('peminjaman.id_peminjaman', 'DESC')
            ->get()->getResultArray();
    }
    public function getByAnggota($id_anggota)
    {
        return $this->db->table('peminjaman')
            ->select('
            peminjaman.*,
            u1.nama as nama_anggota,
            u2.nama as nama_petugas
        ')

            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('users as u1', 'u1.id = anggota.user_id', 'left')

            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
            ->join('users as u2', 'u2.id = petugas.user_id', 'left')

            ->where('peminjaman.id_anggota', $id_anggota)
            ->orderBy('peminjaman.id_peminjaman', 'DESC')
            ->get()->getResultArray();
    }
}
